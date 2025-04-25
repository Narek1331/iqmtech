<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
});

// Route::get('/contact', function () {
//     return view('pages.contact');
// });

Route::get('/consent', function () {
    return view('pages.consent');
});

Route::post('/contact', [ContactController::class, 'sendEmail']);


Route::get('/test', function () {
    $service = new \App\Services\AtsCrmIntegrationService();
    dd($service->updateToken());
});
