<?php

declare(strict_types = 1);

use App\Actions\SystemErrorAlert\UpsertSystemErrorAlert;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Bootstrap\LoadConfiguration;
use Illuminate\Support\Carbon;

require dirname(__DIR__, 4) . '/vendor/autoload.php';

$payload = json_decode(stream_get_contents(STDIN), true, flags: JSON_THROW_ON_ERROR);

/** @var Application $app */
$app = require dirname(__DIR__, 4) . '/bootstrap/app.php';
$app->useEnvironmentPath($payload['directory']);
$app->afterBootstrapping(LoadConfiguration::class, function (Application $application) use ($payload): void {
    $application->make('config')->set([
        'database.default'                       => 'alert_concurrency',
        'database.connections.alert_concurrency' => $payload['connection'],
        'audit.enabled'                          => false,
        'cache.default'                          => 'array',
        'broadcasting.default'                   => 'null',
        'queue.default'                          => 'sync',
        'session.driver'                         => 'array',
        'mail.default'                           => 'array',
    ]);
});
$app->make(Kernel::class)->bootstrap();

$barrier = fopen($payload['directory'] . '/barrier', 'r');
echo "ready\n";
flush();
flock($barrier, LOCK_SH);

$attributes                = $payload['attributes'];
$attributes['occurred_at'] = Carbon::parse($attributes['occurred_at']);

for ($iteration = 0; $iteration < 5; $iteration++) {
    $alert = app(UpsertSystemErrorAlert::class)->handle($attributes);
}

echo $alert->id . "\n";
fclose($barrier);
