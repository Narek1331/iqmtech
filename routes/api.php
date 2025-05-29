<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sync\DataController as SyncDataController;
use App\Http\Controllers\DmpOneController;
use App\Http\Middleware\VerifyJwtClaims;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'sync'], function () {
    Route::post('/data', [SyncDataController::class, 'sync'])->middleware(VerifyJwtClaims::class);
    Route::post('/dmp-one', [DmpOneController::class, 'sync'])->middleware(VerifyJwtClaims::class);
});
