<?php

declare(strict_types = 1);

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Validation\Rules\Unique;

it('returns expected profile update rules', function (): void {
    $user = User::factory()->create();

    $request = ProfileUpdateRequest::create('/profile', 'PATCH');
    $request->setUserResolver(fn (): User => $user);

    $rules = $request->rules();

    expect($rules['name'])->toBe(['required', 'string', 'max:255'])
        ->and($rules['email'][0])->toBe('required')
        ->and($rules['email'][1])->toBe('string')
        ->and($rules['email'][2])->toBe('lowercase')
        ->and($rules['email'][3])->toBe('email')
        ->and($rules['email'][4])->toBe('max:255')
        ->and($rules['email'][5])->toBeInstanceOf(Unique::class);
});
