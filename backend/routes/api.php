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


       


        //order produksi
        Route::get('/orders',        [OrderController::class, 'index']); 
        Route::post('/orders',       [OrderController::class, 'store']);  
        Route::get('/orders/{id}',   [OrderController::class, 'show']);
        Route::patch('/orders/{id}', [OrderController::class, 'update']);
        Route::delete('/orders/{id}',[OrderController::class, 'destroy']);

        //status order produksi
        Route::post('/orders/{id}/start',    [OrderController::class, 'start']);     
        Route::post('/orders/{id}/pause',    [OrderController::class, 'pause']);     
        Route::post('/orders/{id}/resume',   [OrderController::class, 'resume']);    
        Route::post('/orders/{id}/complete', [OrderController::class, 'complete']);  
        Route::post('/orders/{id}/handover', [OrderController::class, 'handover']);  


        //log order produksi
        Route::get('/orders/{id}/logs',       [OrderLogController::class, 'index']);
        Route::post('/orders/{id}/logs',      [OrderLogController::class, 'store']);
        Route::get('/orders/{id}/logs/{logId}', [OrderLogController::class, 'show']);
        Route::patch('/orders/{id}/logs/{logId}',[OrderLogController::class, 'update']);
        Route::delete('/orders/{id}/logs/{logId}',[OrderLogController::class, 'destroy']);



        Route::get('/plans/{id}/status-history',  [PlanController::class, 'statusHistory']);
        Route::get('/orders/{id}/status-history', [OrderController::class, 'statusHistory']);
    });

