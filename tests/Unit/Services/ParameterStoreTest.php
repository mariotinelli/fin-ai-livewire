<?php

declare(strict_types = 1);

use App\Services\ParameterStore;
use Aws\MockHandler;
use Aws\Result;
use Aws\Ssm\SsmClient;

function ssmClientWithParameterStoreResponses(Result ...$results): SsmClient
{
    $mockHandler = new MockHandler();

    foreach ($results as $result) {
        $mockHandler->append($result);
    }

    return new SsmClient([
        'credentials' => [
            'key'    => 'testing-key',
            'secret' => 'testing-secret',
        ],
        'handler' => $mockHandler,
        'region'  => 'us-east-1',
        'version' => 'latest',
    ]);
}

it('returns a decrypted parameter value', function (): void {
    $parameterStore = new ParameterStore(ssmClientWithParameterStoreResponses(new Result([
        'Parameter' => [
            'Name'  => '/application/qa/DB_PASSWORD',
            'Value' => 'secret-password',
        ],
    ])));

    expect($parameterStore->get('/application/qa/DB_PASSWORD'))->toBe('secret-password');
});

it('returns decrypted paginated parameters as environment keys', function (): void {
    $parameterStore = new ParameterStore(ssmClientWithParameterStoreResponses(
        new Result([
            'NextToken'  => 'next-page',
            'Parameters' => [[
                'Name'  => '/application/qa/DB_PASSWORD',
                'Value' => 'secret-password',
            ]],
        ]),
        new Result([
            'Parameters' => [[
                'Name'  => '/application/qa/MAIL/MAIL_PASSWORD',
                'Value' => 'mail-secret',
            ]],
        ]),
    ));

    expect($parameterStore->getByPath('/application/qa'))->toBe([
        'DB_PASSWORD'        => 'secret-password',
        'MAIL_MAIL_PASSWORD' => 'mail-secret',
    ]);
});
