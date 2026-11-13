<?php

declare(strict_types = 1);

use App\Support\QueueNames;

it('isolates applications and environments and resolves names only once', function (): void {
    config()->set('queue.prefix.value', 'alpha');
    app()->detectEnvironment(fn (): string => 'qa');

    expect(QueueNames::resolve('high_priority'))->toBe('alpha_qa_high_priority')
        ->and(QueueNames::resolve('alpha_qa_high_priority'))->toBe('alpha_qa_high_priority');

    config()->set('queue.prefix.value', 'beta');
    expect(QueueNames::resolve('high_priority'))->toBe('beta_qa_high_priority');

    app()->detectEnvironment(fn (): string => 'production');
    expect(QueueNames::resolve('high_priority'))->toBe('beta_production_high_priority');
});

it('keeps original queue names when the prefix is missing in any environment', function (mixed $prefix, string $environment): void {
    config()->set('queue.prefix.value', $prefix);
    app()->detectEnvironment(fn (): string => $environment);

    expect(QueueNames::all())->toBe(['low_priority', 'high_priority', 'long_timeout']);
})->with([null, '', '   ', false])->with(['production', 'prod', 'qa', 'homolog', 'hml', 'testing']);

it('keeps original local queue names unless a prefix is explicitly configured', function (mixed $prefix, string $expected): void {
    app()->detectEnvironment(fn (): string => 'local');
    config()->set('queue.prefix.value', $prefix);

    expect(QueueNames::resolve('high_priority'))->toBe($expected);
})->with([
    'absent'   => [null, 'high_priority'],
    'empty'    => ['', 'high_priority'],
    'blank'    => ['   ', 'high_priority'],
    'false'    => [false, 'high_priority'],
    'explicit' => ['alpha', 'alpha_local_high_priority'],
]);

it('keeps allowed and excluded queue names unchanged when the prefix is missing', function (mixed $prefix): void {
    app()->detectEnvironment(fn (): string => 'production');
    config()->set('queue.prefix.value', $prefix);
    config()->set('queue.prefix.allowed_queues', ['high_priority']);
    config()->set('queue.prefix.excluded_queues', ['long_timeout']);

    expect(QueueNames::all())->toBe(['low_priority', 'high_priority', 'long_timeout']);
})->with([null, '', '   ', false]);

it('rejects unsafe namespace identifiers', function (string $prefix, string $environment): void {
    config()->set('queue.prefix.value', $prefix);
    app()->detectEnvironment(fn (): string => $environment);

    expect(fn (): array => QueueNames::all())->toThrow(InvalidArgumentException::class, 'QUEUE_PREFIX e APP_ENV');
})->with([['app name', 'local'], ['app', 'qa,other'], ['app;cmd', 'local']]);

it('shares allow and exclude rules with consumers', function (): void {
    config()->set('queue.prefix.value', 'alpha');
    config()->set('queue.prefix.allowed_queues', ['high_priority']);
    config()->set('queue.prefix.excluded_queues', ['high_priority']);

    expect(QueueNames::all())->toBe(['low_priority', 'high_priority', 'long_timeout']);
});
