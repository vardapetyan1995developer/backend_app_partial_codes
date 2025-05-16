<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Actions\ShowAction;
use Modules\Auth\Http\Actions\ResetAction;
use Modules\Auth\Http\Actions\UpdateAction;
use Modules\Auth\Http\Actions\SendResetLinkAction;

Route::name('auth.')->prefix('auth')->middleware(['api'])->group(function () {
    Route::middleware(['auth'])->group(function () {
        Route::name('user')->get('user', ShowAction::class);
    });

    Route::name('password.')->prefix('password')->group(function () {
        Route::name('reset')->post('reset', ResetAction::class);
        Route::name('send_reset_link')->post('sendResetLink', SendResetLinkAction::class);

        Route::middleware(['auth'])->group(function () {
            Route::name('update')->post('update', UpdateAction::class);
        });
    });
});
