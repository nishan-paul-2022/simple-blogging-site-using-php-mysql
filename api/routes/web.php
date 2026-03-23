<?php

use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    // Health check endpoint
    Route::get('/health', function () {
        return response()->json(['status' => 'ok']);
    });
});
