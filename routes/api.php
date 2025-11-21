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
POST   /api/register
POST   /api/login
POST   /api/logout

GET    /api/products
GET    /api/products/{id}
POST   /api/products
PUT    /api/products/{id}
DELETE /api/products/{id}

GET    /api/orders
GET    /api/orders/{id}
POST   /api/orders
PUT    /api/orders/{id}
DELETE /api/orders/{id}

GET    /api/transactions
GET    /api/transactions/{id}
POST   /api/transactions
PUT    /api/transactions/{id}
DELETE /api/transactions/{id}
POST   /api/transactions/{id}/process
POST   /api/transactions/{id}/fail
POST   /api/transactions/{id}/refund
GET    /api/transactions-stats

GET    /api/analytics/dashboard
POST   /api/analytics/clear-cache
*/
