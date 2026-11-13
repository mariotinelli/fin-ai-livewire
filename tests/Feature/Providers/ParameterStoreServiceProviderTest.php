<?php

declare(strict_types = 1);

use App\Models\User;
use App\Notifications\NewPasswordNotification;
use App\Providers\ParameterStoreServiceProvider;
use App\Services\ParameterStore;
use Aws\Ssm\SsmClient;
use Illuminate\Foundation\Bootstrap\SetRequestForConsole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

function setParameterStoreEnvironmentValue(string $key, ?string $value): void
{
    if ($value === null) {
        putenv($key);
        unset($_ENV[$key], $_SERVER[$key]);

        return;
    }

    putenv("{$key}={$value}");
    $_ENV[$key]    = $value;
    $_SERVER[$key] = $value;
}

/** @param Closure(string): array<string, string> $resolver */
function parameterStoreFake(Closure $resolver): ParameterStore
{
    return new class ($resolver) extends ParameterStore {
        /** @param Closure(string): array<string, string> $resolver */
        public function __construct(private readonly Closure $resolver)
        {
        }

        /** @return array<string, string> */
        public function getByPath(string $path): array
        {
            return ($this->resolver)($path);
        }
    };
}

it('configures the AWS client with temporary credentials when they are provided', function (?string $sessionToken): void {
    $originalAws = config('services.aws');

    try {
        config()->set('services.aws', [
            'access_key_id'     => 'testing-key',
            'secret_access_key' => 'testing-secret',
            'session_token'     => $sessionToken,
            'default_region'    => 'sa-east-1',
        ]);
        app()->forgetInstance(SsmClient::class);
        new ParameterStoreServiceProvider(app())->register();

        $client      = app(SsmClient::class);
        $credentials = $client->getCredentials()->wait();

        expect($client->getRegion())->toBe('sa-east-1')
            ->and($credentials->getAccessKeyId())->toBe('testing-key')
            ->and($credentials->getSecretKey())->toBe('testing-secret')
            ->and($credentials->getSecurityToken())->toBe($sessionToken);
    } finally {
        config()->set('services.aws', $originalAws);
        app()->forgetInstance(SsmClient::class);
        new ParameterStoreServiceProvider(app())->register();
    }
})->with([
    'long-lived credentials' => null,
    'temporary credentials'  => 'testing-token',
]);

it('falls back to the default AWS region when the configured region is empty', function (): void {
    $originalAws = config('services.aws');

    try {
        config()->set('services.aws', [
            'access_key_id'     => null,
            'secret_access_key' => null,
            'session_token'     => null,
            'default_region'    => '',
        ]);
        app()->forgetInstance(SsmClient::class);
        new ParameterStoreServiceProvider(app())->register();

        expect(app(SsmClient::class)->getRegion())->toBe('us-east-1');
    } finally {
        config()->set('services.aws', $originalAws);
        app()->forgetInstance(SsmClient::class);
        new ParameterStoreServiceProvider(app())->register();
    }
});

it('does not request parameters outside mapped environments', function (): void {
    $originalEnvironment = app()->environment();
    $requested           = false;
    $parameterStore      = parameterStoreFake(function () use (&$requested): array {
        $requested = true;

        return [];
    });

    try {
        app()->detectEnvironment(fn (): string => 'local');

        new ParameterStoreServiceProvider(app())->boot($parameterStore);

        expect($requested)->toBeFalse();
    } finally {
        app()->detectEnvironment(fn (): string => $originalEnvironment);
    }
});

it('loads environment parameters and refreshes Laravel configuration', function (string $environment, string $path): void {
    $originalEnvironment = app()->environment();
    $originalAppName     = getenv('APP_NAME');
    $parameterStore      = parameterStoreFake(function (string $requestedPath) use ($environment, $path): array {
        expect($requestedPath)->toBe($path);

        return ['APP_NAME' => "Projeto Padrão {$environment}"];
    });

    try {
        app()->detectEnvironment(fn (): string => $environment);
        config()->set("services.parameter_store.environments.{$environment}", $path);

        new ParameterStoreServiceProvider(app())->boot($parameterStore);

        expect(getenv('APP_NAME'))->toBe("Projeto Padrão {$environment}")
            ->and(config('app.name'))->toBe("Projeto Padrão {$environment}");
    } finally {
        setParameterStoreEnvironmentValue('APP_NAME', $originalAppName !== false ? $originalAppName : null);
        app()->detectEnvironment(fn (): string => $originalEnvironment);
        config()->set('app.name', $originalAppName);
    }
})->with([
    'qa'         => ['qa', '/application/qa'],
    'hml'        => ['hml', '/application/hml'],
    'homolog'    => ['homolog', '/application/hml'],
    'prod'       => ['prod', '/application/production'],
    'production' => ['production', '/application/production'],
]);

it('logs an AWS failure without replacing existing configuration', function (): void {
    $originalEnvironment = app()->environment();
    $originalAppName     = config('app.name');
    $log                 = Log::spy();
    $parameterStore      = parameterStoreFake(function (string $path): array {
        expect($path)->toBe('/application/qa');

        throw new RuntimeException('AWS is unavailable');
    });

    try {
        app()->detectEnvironment(fn (): string => 'qa');
        config()->set('services.parameter_store.environments.qa', '/application/qa');
        config()->set('app.name', 'Existing application');

        new ParameterStoreServiceProvider(app())->boot($parameterStore);

        expect(config('app.name'))->toBe('Existing application');
        $log->shouldHaveReceived('error')
            ->once()
            ->with('Falha ao carregar parâmetros do AWS Parameter Store.', [
                'environment' => 'qa',
                'path'        => '/application/qa',
                'exception'   => 'AWS is unavailable',
            ]);
    } finally {
        app()->detectEnvironment(fn (): string => $originalEnvironment);
        config()->set('app.name', $originalAppName);
    }
});

it('uses the freshly loaded app URL for password reset links in the console', function (string $appUrl): void {
    $originalEnvironment = app()->environment();
    $originalAppUrl      = getenv('APP_URL');
    $originalRequest     = app('request');
    $originalConfig      = config()->all();
    $parameterStore      = parameterStoreFake(fn (): array => ['APP_URL' => $appUrl]);
    $user                = User::factory()->user()->make(['email' => 'maria@example.com']);
    $notification        = new NewPasswordNotification('reset-token');

    try {
        app()->detectEnvironment(fn (): string => 'qa');
        config()->set('services.parameter_store.environments.qa', '/application/qa');
        config()->set('app.url', 'http://old.example');
        new SetRequestForConsole()->bootstrap(app());
        expect($notification->toMail($user)->actionUrl)->toStartWith('http://old.example/');

        new ParameterStoreServiceProvider(app())->boot($parameterStore);

        expect($notification->toMail($user)->actionUrl)
            ->toBe($appUrl . '/nova-senha/reset-token?email=maria%40example.com&context=admin');
    } finally {
        setParameterStoreEnvironmentValue('APP_URL', $originalAppUrl !== false ? $originalAppUrl : null);
        app()->detectEnvironment(fn (): string => $originalEnvironment);
        config()->set($originalConfig);
        app()->instance('request', $originalRequest);
    }
})->with([
    'HTTPS host'         => 'https://loaded.example',
    'port and base path' => 'https://loaded.example:8443/application',
]);

it('preserves the incoming HTTP request when applying Parameter Store configuration', function (): void {
    $originalEnvironment = app()->environment();
    $originalAppUrl      = getenv('APP_URL');
    $originalRequest     = app('request');
    $originalConfig      = config()->all();
    $console             = new ReflectionProperty(app(), 'isRunningInConsole');
    $originalConsole     = $console->getValue(app());
    $request             = Request::create('https://incoming.example/form', 'POST', ['value' => 'submitted']);
    $parameterStore      = parameterStoreFake(fn (): array => ['APP_URL' => 'https://loaded.example']);

    try {
        $console->setValue(app(), false);
        app()->instance('request', $request);
        app()->detectEnvironment(fn (): string => 'qa');
        config()->set('services.parameter_store.environments.qa', '/application/qa');

        new ParameterStoreServiceProvider(app())->boot($parameterStore);

        expect(config('app.url'))->toBe('https://loaded.example');
        expect(app('request'))->toBe($request);
        expect(app('request')->input('value'))->toBe('submitted');
        expect(route('password.reset', ['token' => 'reset-token']))
            ->toBe('https://incoming.example/nova-senha/reset-token');
    } finally {
        setParameterStoreEnvironmentValue('APP_URL', $originalAppUrl !== false ? $originalAppUrl : null);
        app()->detectEnvironment(fn (): string => $originalEnvironment);
        config()->set($originalConfig);
        $console->setValue(app(), $originalConsole);
        app()->instance('request', $originalRequest);
    }
});
