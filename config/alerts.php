<?php

declare(strict_types = 1);

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return [
    'redaction' => [
        /** Credentials are always redacted; add application-specific field names here. */
        'sensitive_keys' => [],
        /** Diagnostic text is filtered, objects/resources omitted, and trace arguments removed. */
        'text_limit'    => 2000,
        'message_limit' => 4000,
        'url_limit'     => 2048,
        'trace_limit'   => 12000,
        'context_depth' => 6,
        'context_items' => 100,
    ],
    'discord' => [
        'enabled'            => (bool) env('DISCORD_ALERTS_ENABLED', false),
        'webhook_url'        => env('DISCORD_ALERT_WEBHOOK_URL'),
        'timeout'            => (int) env('DISCORD_ALERT_TIMEOUT', 3),
        'retry_times'        => (int) env('DISCORD_ALERT_RETRY_TIMES', 2),
        'retry_sleep_ms'     => (int) env('DISCORD_ALERT_RETRY_SLEEP_MS', 200),
        'throttle_seconds'   => (int) env('DISCORD_ALERT_THROTTLE_SECONDS', 60),
        'trace_lines'        => (int) env('DISCORD_ALERT_TRACE_LINES', 12),
        'ignored_exceptions' => [
            ValidationException::class,
            AuthenticationException::class,
            AuthorizationException::class,
            NotFoundHttpException::class,
            MethodNotAllowedHttpException::class,
        ],
    ],
];
