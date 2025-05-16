<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Actions\ShowAction;
use Modules\Admin\Http\Actions\IndexAction;
use Modules\Admin\Http\Actions\DeleteAction;
use Modules\Admin\Http\Actions\UpdateAction;
use Modules\Admin\Http\Actions\AcceptTermsAction;
use Modules\Admin\Http\Actions\UpdatePasswordAction;

Route::name('admin.')->prefix('admins')->middleware(['api', 'auth:api'])->group(function () {
    Route::middleware(['role:SUPER_ADMIN'])->group(function () {
        Route::name('index')->get('/', IndexAction::class);
        Route::name('create')->post('/', \Modules\Admin\Http\Actions\CreateAction::class);
    });

    Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
        Route::middleware(['role:SUPER_ADMIN'])->group(function () {
            Route::name('show')->get('/', ShowAction::class);
            Route::name('update')->put('/', UpdateAction::class);
            Route::name('delete')->delete('/', DeleteAction::class);
            Route::name('update_password')->post('updatePassword', UpdatePasswordAction::class);
        });

        Route::name('accept_terms')->post('acceptTerms', AcceptTermsAction::class);
    });
});
