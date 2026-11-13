<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Services\ParameterStore;
use Aws\Ssm\SsmClient;
use Illuminate\Foundation\Bootstrap\SetRequestForConsole;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Throwable;

class ParameterStoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SsmClient::class, fn (): SsmClient => new SsmClient($this->clientConfig()));
        $this->app->singleton(ParameterStore::class);
    }

    public function boot(ParameterStore $parameterStore): void
    {
        $path = $this->parameterStorePath();

        if ($path === null) {
            return;
        }

        try {
            $this->applyEnvironmentVariables($parameterStore->getByPath($path));
            $this->reloadConfiguration();
        } catch (Throwable $throwable) {
            Log::error('Falha ao carregar parâmetros do AWS Parameter Store.', [
                'environment' => $this->app->environment(),
                'path'        => $path,
                'exception'   => $throwable->getMessage(),
            ]);
        }
    }

    /** @return array<string, mixed> */
    private function clientConfig(): array
    {
        $region = config('services.aws.default_region', 'us-east-1');
        $config = [
            'region'  => is_string($region) && $region !== '' ? $region : 'us-east-1',
            'version' => 'latest',
        ];

        $accessKey    = config('services.aws.access_key_id');
        $secretKey    = config('services.aws.secret_access_key');
        $sessionToken = config('services.aws.session_token');

        if (is_string($accessKey) && $accessKey !== '' && is_string($secretKey) && $secretKey !== '') {
            $config['credentials'] = [
                'key'    => $accessKey,
                'secret' => $secretKey,
            ];

            if (is_string($sessionToken) && $sessionToken !== '') {
                $config['credentials']['token'] = $sessionToken;
            }
        }

        return $config;
    }

    private function parameterStorePath(): ?string
    {
        $path = config('services.parameter_store.environments.' . $this->app->environment());

        return is_string($path) && $path !== '' ? $path : null;
    }

    /** @param array<string, string> $parameters */
    private function applyEnvironmentVariables(array $parameters): void
    {
        foreach ($parameters as $key => $value) {
            putenv("{$key}={$value}");
            $_ENV[$key]    = $value;
            $_SERVER[$key] = $value;
        }
    }

    private function reloadConfiguration(): void
    {
        foreach (glob(config_path('*.php')) ?: [] as $configPath) {
            config()->set(basename($configPath, '.php'), require $configPath);
        }

        if ($this->app->runningInConsole()) {
            new SetRequestForConsole()->bootstrap($this->app);
        }
    }
}
