<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;


Route::get('/', function () {
    return view('payment');
})->name('home');

Route::post('/create-payment', [PaymentController::class, 'createPayment'])->name('create.payment');

Route::get('/payment/success/{idPayment?}', [PaymentController::class, 'paymentSuccess'])->name('payment.success');

Route::get('/payment/error', function () {
    return view('payment_error');
})->name('payment.error');
