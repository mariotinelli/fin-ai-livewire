<?php

declare(strict_types = 1);

use App\Livewire\Admin\Auth\Login as AdminLogin;
use App\Livewire\Customer\Auth\Login as CustomerLogin;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;

use function Pest\Livewire\livewire;

it('shares the failed login limit across authentication areas', function (): void {
    Event::fake([Lockout::class]);
    $email = 'limited@example.test';
    RateLimiter::clear($email . '|127.0.0.1');

    foreach (range(1, 5) as $attempt) {
        livewire(AdminLogin::class)->set('email', $email)->set('password', 'invalid')
            ->call('login')->assertHasErrors('email');
    }

    livewire(CustomerLogin::class)->set('email', $email)->set('password', 'invalid')
        ->call('login')->assertHasErrors('email');
    Event::assertDispatched(Lockout::class);
    $this->assertGuest();
});
