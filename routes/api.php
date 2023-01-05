<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\PaymentController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::controller(CustomerController::class)->group(function () {
    Route::get('/customers', 'index');
    Route::post('/customer', 'store');
    Route::get('/customer/{id}', 'show');
    Route::put('/customer/{id}', 'update');
    Route::delete('/customer/{id}', 'destroy');
});

Route::controller(InstallmentController::class)->group(function () {
    Route::get('/installments', 'index');
    Route::post('/installment', 'store');
    Route::get('/installment/{id}', 'show');
    Route::put('/installment/{id}', 'update');
    Route::delete('/installment/{id}', 'destroy');
});

Route::controller(PaymentController::class)->group(function () {
    Route::post('/payment', 'store');
    Route::put('/payment/{id}', 'update');
});

 
