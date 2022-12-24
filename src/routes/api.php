<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TravelPaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('payments', PaymentController::class);
    Route::post('payments/{payment}/approval', [PaymentController::class, 'approveOrDisapprove']);

    Route::apiResource('travel-payments', TravelPaymentController::class);
    Route::post('travel-payments/{travel_payment}/approval', [TravelPaymentController::class, 'approveOrDisapprove']);

    Route::get('report', [ReportController::class, 'report']);
});
