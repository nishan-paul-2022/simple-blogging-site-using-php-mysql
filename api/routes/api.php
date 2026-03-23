<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});

Route::get('/', function () {
    return response()->json([
        'name' => 'Blog API',
        'version' => '1.0.0',
        'status' => 'active'
    ]);
});

// Public endpoints
Route::group(['prefix' => 'posts'], function () {
    Route::get('/', [PostController::class, 'index']);
    Route::get('/featured', [PostController::class, 'featured']);
    Route::get('/popular', [PostController::class, 'popular']);
    Route::get('/{slug}', [PostController::class, 'show']);
    Route::get('/{post}/related', [PostController::class, 'related']);
});

// Public category endpoints
Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/{category:slug}', [CategoryController::class, 'show']);
    Route::get('/{category:slug}/posts', [CategoryController::class, 'posts']);
});

// Public tag endpoints
Route::group(['prefix' => 'tags'], function () {
    Route::get('/', [TagController::class, 'index']);
    Route::get('/{tag:slug}', [TagController::class, 'show']);
    Route::get('/{tag:slug}/posts', [TagController::class, 'posts']);
    Route::get('/autocomplete', [TagController::class, 'autocomplete']);
});

// Public comment endpoints
Route::group(['prefix' => 'posts/{post}/comments'], function () {
    Route::get('/', [CommentController::class, 'index']);
});

// Authentication endpoints
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::put('/profile', [AuthController::class, 'updateProfile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});

// Protected endpoints (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    // Post creation and update
    Route::group(['prefix' => 'posts'], function () {
        Route::post('/', [PostController::class, 'store']);
        Route::put('/{post}', [PostController::class, 'update']);
        Route::delete('/{post}', [PostController::class, 'destroy']);
    });

    // Comment endpoints
    Route::group(['prefix' => 'posts/{post}/comments'], function () {
        Route::post('/', [CommentController::class, 'store']);
        Route::delete('/{comment}', [CommentController::class, 'destroy']);
    });

    // Admin endpoints
    Route::middleware(['admin'])->group(function () {
        // Categories
        Route::group(['prefix' => 'admin/categories'], function () {
            Route::post('/', [CategoryController::class, 'store']);
            Route::put('/{category}', [CategoryController::class, 'update']);
            Route::delete('/{category}', [CategoryController::class, 'destroy']);
        });

        // Comments - approve
        Route::post('/admin/comments/{comment}/approve', [CommentController::class, 'approve']);
    });
});

