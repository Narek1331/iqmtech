<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
});

Route::get('/consent', function () {
    return view('pages.consent');
});

Route::get('/user-agreement', function () {
    return view('pages.user-agreement');
});

Route::post('/contact', [ContactController::class, 'sendEmail']);


