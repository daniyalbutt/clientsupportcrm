<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\RoleController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
})->middleware('auth');


Route::get('/pay/{id}', [FrontController::class, 'payNow'])->name('pay');
Route::get('/invoice/{id}', [FrontController::class, 'invoice'])->name('invoice');
Route::post('pay.now', [StripeController::class, 'stripePost'])->name('pay.now');
Route::get('success/{id}', [StripeController::class, 'successPayment'])->name('success.payment');
Route::get('declined/{id}', [StripeController::class, 'declinedPayment'])->name('declined.payment');

// Route::get('stripe', [StripeController::class, 'stripe']);
Route::post('stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
Route::post('process-payment', [StripeController::class, 'processPayment'])->name('process.payment');

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('clients', ClientController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('merchant', MerchantController::class);
    Route::resource('currency', CurrencyController::class);
    Route::get('client/logo-brief/{id}', [ClientController::class, 'logoBrief'])->name('logo.brief');
    Route::resource('payment', PaymentController::class);
    Route::get('invoice/download/{id}', [PaymentController::class, 'invoiceDownload'])->name('invoice.download');
    Route::get('show/response/{id}', [App\Http\Controllers\HomeController::class, 'showResponse'])->name('show.response');
    Route::get('payment/delete/{id}', [PaymentController::class, 'delete'])->name('payment.delete');
    Route::get('change-password', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('change.index');
    Route::post('change-password', [App\Http\Controllers\HomeController::class, 'changePasswordStore'])->name('change.password');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::post('sale/front', [StripeController::class, 'saleFront'])->name('sale.front');
});

Auth::routes(['register' => false]);


