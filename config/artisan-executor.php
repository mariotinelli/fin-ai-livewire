<?php

declare(strict_types = 1);

return [
    'allowed_ips' => array_values(array_filter(array_map(
        trim(...),
        explode(',', (string) env('ARTISAN_EXECUTOR_ALLOWED_IPS', ''))
    ))),

    'blocked_commands' => [
        'down',
        'migrate:fresh',
        'migrate:refresh',
        'db:wipe',
    ],

    /** Cada entrada autoriza combinações completas de argumentos, sem curingas. */
    'commands_by_environment' => [
        'local'      => ['about' => [[], ['--only=environment']]],
        'testing'    => ['about' => [[], ['--only=environment']]],
        'homolog'    => ['about' => [['--only=environment']]],
        'production' => ['about' => [['--only=environment']]],
    ],

    'max_output_bytes' => (int) env('ARTISAN_EXECUTOR_MAX_OUTPUT_BYTES', 65536),

    'timeout' => max(1, min(120, (int) env('ARTISAN_EXECUTOR_TIMEOUT', 120))),

    'php_binary' => env('ARTISAN_EXECUTOR_PHP_BINARY', ''),
];
