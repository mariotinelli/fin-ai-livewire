<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;

beforeEach(function (): void {
    View::share('errors', new ViewErrorBag());
});

it('serializes the dispatched event name for Alpine', function (): void {
    $eventName = <<<'PAYLOAD'
        updated'; window.rsp53Executed = true; //
        PAYLOAD;

    $html = Blade::render('<x-ui.input.commands.autocomplete :event-name="$eventName" />', ['eventName' => $eventName]);

    expect($html)
        ->toContain('this.$dispatch(\'updated\\u0027; window.rsp53Executed = true; \\/\\/\'')
        ->not->toContain("this.\$dispatch('{$eventName}'");
});
