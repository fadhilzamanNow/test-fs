<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthSimpleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\OrderController;         // production orders
use App\Http\Controllers\OrderLogController;      // production logs
use App\Http\Controllers\UserController;
use App\Http\Controllers\LookupController;
use App\Http\Controllers\PlanLogController;

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login',    [AuthController::class, 'login']);
    });

    // -------- Protected (JWT) --------
    Route::middleware('jwt')->group(function () {
        // auth
        Route::get('/auth/me',     [AuthController::class, 'me']);

        // produk
        Route::get('/products',        [ProductController::class, 'index']);   
        Route::post('/products',       [ProductController::class, 'store']);
        Route::get('/products/{id}',   [ProductController::class, 'show']);
        Route::patch('/products/{id}', [ProductController::class, 'update']);
        Route::delete('/products/{id}',[ProductController::class, 'destroy']);

        //rencana produksi
        Route::get('/plans',        [PlanController::class, 'index']);  
        Route::post('/plans',       [PlanController::class, 'store']);
        Route::get('/plans/{id}',   [PlanController::class, 'show']);
        Route::patch('/plans/{id}', [PlanController::class, 'update']);
        Route::delete('/plans/{id}',[PlanController::class, 'destroy']);
        Route::patch('/plans/{id}/status',[PlanController::class, 'changeStatus']);


    
    Route::prefix('/orders')->group(function () {
    // list all orders with pagination + search
    Route::get('/', [OrderController::class, 'index']);

    // get detail of single order (with logs, creator, plan, etc.)
    Route::get('/{id}', [OrderController::class, 'show']);

    // change status of order (logs written automatically)
    Route::post('/{id}/status', [OrderController::class, 'updateStatus']);
});

Route::prefix('/order-logs')->group(function () {
    // list logs (optional: filter by order_id)
    Route::get('/', [OrderLogController::class, 'index']);

    // get detail of a single log
    Route::get('/{id}', [OrderLogController::class, 'show']);
});


Route::get('/plan-logs', [PlanLogController::class, 'index']);
Route::get('/plan-logs/{id}', [PlanLogController::class, 'show']);

    });



