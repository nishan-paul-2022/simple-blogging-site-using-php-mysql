<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});

Route::get('/api', function () {
    return response()->json([
        'name' => 'Blog API',
        'version' => '1.0.0',
        'status' => 'active'
    ]);
});

// Temporary API endpoints - to be replaced with controllers
Route::group(['prefix' => 'api', 'middleware' => 'api'], function () {
    
    Route::get('/posts', function () {
        return response()->json([
            'data' => [],
            'message' => 'Posts endpoint - coming soon'
        ]);
    });

    Route::post('/posts', function () {
        return response()->json([
            'message' => 'Create post endpoint - coming soon'
        ], 201);
    });

    Route::get('/categories', function () {
        return response()->json([
            'data' => [],
            'message' => 'Categories endpoint - coming soon'
        ]);
    });

    Route::get('/tags', function () {
        return response()->json([
            'data' => [],
            'message' => 'Tags endpoint - coming soon'
        ]);
    });

    Route::post('/auth/register', function (Request $request) {
        return response()->json([
            'message' => 'Register endpoint - coming soon'
        ], 201);
    });

    Route::post('/auth/login', function (Request $request) {
        return response()->json([
            'message' => 'Login endpoint - coming soon'
        ]);
    });

});
