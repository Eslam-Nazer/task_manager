<?php

use App\Http\Controllers\Api\AccessApiTokensController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/access-tokens', [AccessApiTokensController::class, 'store'])
    ->middleware('guest:sanctum');

Route::middleware('auth:sanctum')->delete('auth/logout/{token?}', [AccessApiTokensController::class, 'destroy']);
