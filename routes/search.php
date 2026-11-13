<?php

declare(strict_types = 1);

use App\Http\Controllers\Search;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '/search', 'as' => 'search.'], function (): void {
    Route::get('users', Search\UsersController::class)
        ->middleware('auth')
        ->name('users');

    Route::get('roles', Search\RolesController::class)
        ->middleware('auth')
        ->name('roles');

    Route::get('states', Search\StatesController::class)
        ->name('states');
});
