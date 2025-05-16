<?php

use Illuminate\Support\Facades\Route;
use Modules\Client\Http\Actions\ShowAction;
use Modules\Client\Http\Actions\IndexAction;
use Modules\Client\Http\Actions\CreateAction;
use Modules\Client\Http\Actions\DeleteAction;
use Modules\Client\Http\Actions\UpdateAction;
use Modules\Client\Http\Actions\AcceptTermsAction;
use Modules\Client\Http\Actions\UpdatePasswordAction;

Route::name('client.')->prefix('clients')->middleware(['api', 'auth:api'])->group(function () {
    Route::name('index')->get('/', IndexAction::class);
    Route::name('create')->post('/', CreateAction::class);

    Route::prefix('{id}')->where(['id' => '[0-9]+'])->group(function () {
        Route::name('show')->get('/', ShowAction::class);
        Route::name('update')->put('/', UpdateAction::class);
        Route::name('delete')->delete('/', DeleteAction::class);
    });
});
