<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ServiceController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [InvoiceController::class, 'index'])->name('invoice.index');
Route::post('/invoice-save', [InvoiceController::class, 'store'])->name('store.invoice');
Route::get('/generate-invoice/{id}', [InvoiceController::class, 'generateInvoice'])->name('generate.invoice');
Route::get('/check-invoice', [InvoiceController::class, 'checkInvoice'])->name('check.invoice');
Route::post('/check-invoice-post', [InvoiceController::class, 'checkInvoicePost'])->name('check.invoice.post');



Route::get('/create-service', [ServiceController::class, 'create'])->name('create.service');
Route::post('/save-service', [ServiceController::class, 'store'])->name('store.service');
Route::get('/service-hourly-rate/{id}', [ServiceController::class, 'fetchHourlyRate'])->name('fetch.hourly.rate');


Route::get('/test', [InvoiceController::class, 'test']);
Route::get('/test2/{invoiceId}', [InvoiceController::class, 'showInvoiceDetails']);