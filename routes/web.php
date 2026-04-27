<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\PriceProceduresController;
use App\Http\Controllers\ProceduresController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VoucherController;

Route::get('/test', [AuthenticatedSessionController::class, 'test'])->name('test');

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // INSURANCE
    Route::resource('insurances', InsuranceController::class);
    Route::get('insurances-data', [InsuranceController::class, 'getDataTable'])->name('insurances.data');
    
    // PROCEDURES
    Route::resource('procedures', ProceduresController::class);
    Route::get('procedures-data', [ProceduresController::class, 'getDataTable'])->name('procedures.data');

    // PRICE PROCEDURE
    Route::get('price-procedure-data/{id}', [PriceProceduresController::class, 'getDataTable'])->name('price-procedure.data');

    // VOUCHER
    Route::resource('vouchers', VoucherController::class);
    Route::get('vouchers-data', [VoucherController::class, 'getDataTable'])->name('vouchers.data');

    // TRANSACTION
    Route::resource('transactions', TransactionController::class);
    Route::get('transactions-data', [TransactionController::class, 'getDataTable'])->name('transactions.data');
    Route::get('transactions-get-voucher', [TransactionController::class, 'getVoucher'])->name('transactions.get-voucher');
    Route::get('transactions-get-price', [TransactionController::class, 'getPrice'])->name('transactions.get-price');
    Route::post('transactions-pay/{id}', [TransactionController::class, 'pay'])->name('transactions.pay');
    Route::get('transactions-print/{id}', [TransactionController::class, 'print'])->name('transactions.print');

    Route::get('signout', [AuthenticatedSessionController::class, 'signout'])->name('signout');
});

require __DIR__.'/auth.php';
