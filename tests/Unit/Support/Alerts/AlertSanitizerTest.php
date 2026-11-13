<?php

declare(strict_types = 1);

use App\Support\Alerts\AlertSanitizer;

it('redacts credential name variants throughout structured data', function (string $key): void {
    $sanitizer = new AlertSanitizer();

    expect($sanitizer->context(['nested' => [[$key => 'SENTINEL_CREDENTIAL', 'page' => 2]]]))
        ->toBe(['nested' => [[$key => '**********', 'page' => 2]]]);
})->with(['access_token', 'refreshToken', 'API_KEY', 'client-secret', 'password_confirmation', 'Authorization', 'Set-Cookie', 'X.Api.Key', 'private_key', 'session_id', 'X-CSRF-Token', 'credentials', 'signed_signature', 'auth%5Btoken%5D']);

it('preserves safe query parameters while redacting encoded duplicate and nested credentials', function (): void {
    $url = 'https://SENTINEL_USER:SENTINEL_PASS@example.test/path?page=2&access_token=SENTINEL_A&access_token=SENTINEL_B&auth%5Bapi_key%5D=SENTINEL_C&sort=name#SENTINEL_FRAGMENT';

    $result = new AlertSanitizer()->url($url);

    expect($result)->toBe('https://**********@example.test/path?page=2&access_token=**********&access_token=**********&auth%5Bapi_key%5D=**********&sort=name');
});

it('redacts recognizable secrets in free text before truncation', function (string $text): void {
    expect(new AlertSanitizer()->text($text))->not->toContain('SENTINEL');
})->with([
    'assignment'                => 'Failed access_token=SENTINEL_TOKEN',
    'json'                      => '{"client_secret":"SENTINEL WITH SPACES","page":2}',
    'quoted command'            => "php worker --password='SENTINEL WITH SPACES' --once",
    'command argument'          => "php worker --api-key 'SENTINEL KEY'",
    'unquoted command argument' => 'php worker --api-key SENTINEL_KEY --tries 3',
    'bearer'                    => 'Request used Bearer SENTINEL_BEARER',
    'basic'                     => 'Basic SENTINEL_BASIC',
    'cookie'                    => 'Cookie: name=SENTINEL_COOKIE; another=SENTINEL_SECOND',
    'url'                       => 'Failed https://example.test/?api_key=SENTINEL_URL&page=2',
    'pem'                       => "-----BEGIN RSA PRIVATE KEY-----\nSENTINEL_PRIVATE\n-----END RSA PRIVATE KEY-----",
    'jwt'                       => 'eyJSENTINEL.eyJSENTINEL.SENTINEL',
]);

it('redacts known credentials repeated without labels without retaining them for another report', function (): void {
    $sources   = ['client_secret' => 'SENTINEL with spaces', 'auth' => ['token' => ['SENTINEL_ARRAY']], 'authorization' => 'Bearer SENTINEL_AUTH'];
    $sanitizer = new AlertSanitizer($sources);

    expect($sanitizer->text('Failure SENTINEL with spaces SENTINEL%20with%20spaces SENTINEL_ARRAY SENTINEL_AUTH'))->toBe('Failure ********** ********** ********** **********')
        ->and(new AlertSanitizer()->text('SENTINEL with spaces'))->toBe('SENTINEL with spaces');
});

it('extends credential classification without disabling built in rules', function (): void {
    config()->set('alerts.redaction.sensitive_keys', ['custom-pin', '']);

    expect(new AlertSanitizer()->context(['customPin' => 'SENTINEL', 'access_token' => 'SENTINEL', 'page' => 3]))
        ->toBe(['customPin' => '**********', 'access_token' => '**********', 'page' => 3]);
});

it('redacts known secrets used as context keys while preserving credential field names', function (): void {
    $sanitizer = new AlertSanitizer(['token' => 'k', 'api_key' => 'SENTINEL_KEY']);

    expect($sanitizer->context(['token' => 'k', 'SENTINEL_KEY' => 'safe']))
        ->toBe(['token' => '**********', '**********' => 'safe']);
});

it('bounds context depth total entries and multibyte strings', function (): void {
    config()->set('alerts.redaction.context_depth', 1);
    config()->set('alerts.redaction.context_items', 4);
    config()->set('alerts.redaction.text_limit', 4);

    expect(new AlertSanitizer()->context([
        'a'        => ['b' => ['c' => 'SENTINEL']],
        'text'     => 'áéíóú',
        'safe'     => true,
        'overflow' => 'SENTINEL',
    ]))->toBe(['a' => ['b' => '**********'], 'text' => 'áéí…', 'safe' => true, '__truncated__' => true]);
});

it('omits objects resources invalid text and non finite numbers without serializing them', function (): void {
    $object = new class () implements JsonSerializable {
        public function jsonSerialize(): mixed
        {
            throw new LogicException('Objects must not be serialized');
        }
    };
    $resource = fopen('php://memory', 'r');

    try {
        expect(new AlertSanitizer()->context(['object' => $object, 'resource' => $resource, 'bad' => "\xB1", 'float' => INF, 'null' => null, 'number' => 2.5]))
            ->toBe(['object' => '**********', 'resource' => '**********', 'bad' => '**********', 'float' => '**********', 'null' => null, 'number' => 2.5]);
    } finally {
        fclose($resource);
    }
});

it('bounds recursive sources and contexts', function (): void {
    $data          = ['safe' => 'ok'];
    $data['cycle'] = &$data;

    $sanitizer = new AlertSanitizer($data);

    expect(json_encode($sanitizer->context($data), JSON_THROW_ON_ERROR))->toContain('**********');
});

it('removes legacy trace arguments including multiline values', function (): void {
    $trace = "#0 /app/Test.php(10): execute('SENTINEL\nMULTILINE')\n#1 [internal function]: dispatch('SENTINEL_SECOND')\n#2 {main}";

    expect(new AlertSanitizer()->trace($trace))->not->toContain('SENTINEL', 'MULTILINE')->toContain('/app/Test.php', 'dispatch', '#2 {main}');
});

it('preserves null inputs and enforces limits even for invalid configuration', function (): void {
    config()->set('alerts.redaction.url_limit', 0);
    config()->set('alerts.redaction.trace_limit', 999999);

    $sanitizer = new AlertSanitizer();

    expect($sanitizer->text(null))->toBeNull()
        ->and($sanitizer->url(null))->toBeNull()
        ->and($sanitizer->url("/invalid\xB1"))->toBe('**********')
        ->and($sanitizer->trace(null))->toBeNull()
        ->and($sanitizer->url('/safe'))->toBe('…')
        ->and(mb_strlen($sanitizer->trace(str_repeat('a', 13000))))->toBe(12000)
        ->and($sanitizer->text('secret=' . str_repeat('SENTINEL', 1000), 20))->toBe('secret=**********');
});

it('sanitizes safe nested URLs and empty query parameters idempotently', function (): void {
    $sanitizer = new AlertSanitizer();
    $url       = 'https://example.test/?next=https%3A%2F%2Fsafe.test%2F%3Fapi_key%3DSENTINEL&flag&empty=';
    $safe      = $sanitizer->url($url);

    expect($safe)->not->toContain('SENTINEL')->toContain('&flag&empty=')
        ->and($sanitizer->url($safe))->toBe($safe);
});
