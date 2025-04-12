<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/check-db', function() {
    try {
        DB::connection()->getPdo();
        return "Connected! Database: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
});
