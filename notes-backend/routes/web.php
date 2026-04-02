<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/metrics', function () {
    $metrics = "app_requests_total 1\n";
    return response($metrics, 200)
        ->header('Content-Type', 'text/plain');
});