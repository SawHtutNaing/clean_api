<?php

use App\Http\Controllers\Api\AnalyticsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
use Illuminate\Support\Facades\Route;

// =========================
// API V1
// =========================
Route::prefix('v1')->group(function () {

    // -------------------------
    // Public Routes
    // -------------------------
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // -------------------------
    // Protected Routes
    // -------------------------
    Route::middleware('auth:sanctum')->group(function () {

        // Auth routes
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/refresh', [AuthController::class, 'refresh']);

        // Product routes
        Route::apiResource('products', ProductController::class);

        // Order routes
        Route::apiResource('orders', OrderController::class);

        // Transaction routes
        Route::apiResource('transactions', TransactionController::class);
        Route::post('/transactions/{transaction}/process', [TransactionController::class, 'process']);
        Route::post('/transactions/{transaction}/fail', [TransactionController::class, 'fail']);
        Route::post('/transactions/{transaction}/refund', [TransactionController::class, 'refund']);
        Route::get('/transactions-stats', [TransactionController::class, 'stats']);

        // Analytics routes
        Route::prefix('analytics')->group(function () {
            Route::get('/dashboard', [AnalyticsController::class, 'dashboard']);
            Route::post('/clear-cache', [AnalyticsController::class, 'clearCache']);
        });
    });
});

// Example API endpoints:
/*
POST   /api/v1/register
POST   /api/v1/login
POST   /api/v1/logout

GET    /api/v1/products
GET    /api/v1/products/{id}
POST   /api/v1/products
PUT    /api/v1/products/{id}
DELETE /api/v1/products/{id}

GET    /api/v1/orders
GET    /api/v1/orders/{id}
POST   /api/v1/orders
PUT    /api/v1/orders/{id}
DELETE /api/v1/orders/{id}

GET    /api/v1/transactions
GET    /api/v1/transactions/{id}
POST   /api/v1/transactions
PUT    /api/v1/transactions/{id}
DELETE /api/v1/transactions/{id}
POST   /api/v1/transactions/{id}/process
POST   /api/v1/transactions/{id}/fail
POST   /api/v1/transactions/{id}/refund
GET    /api/v1/transactions-stats

GET    /api/v1/analytics/dashboard
POST   /api/v1/analytics/clear-cache
*/
