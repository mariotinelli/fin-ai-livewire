<?php

declare(strict_types = 1);

use App\Support\ArtisanHistoryRedactor;

it('redacts secret labels and credential URLs', function (string $input): void {
    expect(app(ArtisanHistoryRedactor::class)->redact($input))->not->toContain('canary');
})->with([
    'password=canary', '--token canary', '{"api_key":"canary"}', 'Authorization: Bearer canary',
    'mysql://user:canary@localhost/db', "-----BEGIN PRIVATE KEY-----\ncanary\n-----END PRIVATE KEY-----",
    "-----BEGIN PRIVATE KEY-----\ncanary", 'APP_KEY: canary', 'senha: canary',
    "{\"password\": \"first\ncanary\"}",
]);

it('redacts configured secret values without hiding ordinary output', function (): void {
    config()->set('services.example.token', 'canary-value');

    expect(app(ArtisanHistoryRedactor::class)->redact("OK\ncanary-value\nFinished"))->toBe("OK\n[REDACTED]\nFinished");
});

it('omits oversized history output completely', function (): void {
    config()->set('artisan-executor.max_output_bytes', 128);

    expect(app(ArtisanHistoryRedactor::class)->redact(str_repeat('x', 129)))->toBe('[Saída omitida: limite excedido.]');
});

it('keeps a finite output limit for invalid settings', function (mixed $setting, int $expected): void {
    config()->set('artisan-executor.max_output_bytes', $setting);

    expect(app(ArtisanHistoryRedactor::class)->limit())->toBe($expected);
})->with([[null, 65536], [0, 65536], [-1, 65536], ['100', 65536], [1, 128], [PHP_INT_MAX, 1048576]]);
