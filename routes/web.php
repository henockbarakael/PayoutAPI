<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});

// -----------------------------login----------------------------------------//
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'authenticate']);
Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'storeUser'])->name('register.store');
Route::post('/verify', [App\Http\Controllers\Auth\RegisterController::class, 'verify'])->name('verify.post');

Route::group(['prefix'=>'admin', 'middleware'=>['admin','auth','PreventBackHistory']], function(){

    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin.dashboard');

    Route::get('merchant-list', [App\Http\Controllers\Admin\MerchantController::class, 'merchantList'])->name('admin.merchant.list');
    Route::get('merchant-user', [App\Http\Controllers\Admin\MerchantController::class, 'merchantUser'])->name('admin.merchant.use.list');

    Route::get('bulk-payment', [App\Http\Controllers\Admin\TransactionsController::class, 'payout'])->name('admin.payout');
    Route::post('bulk-payment', [App\Http\Controllers\Admin\TransactionsController::class, 'process_payout'])->name('admin.import');

    Route::get('payment-history', [App\Http\Controllers\Admin\TransactionsController::class, 'payout_logs'])->name('admin.payout.history');

    Route::get('admin-profile', [App\Http\Controllers\Admin\ProfileController::class, 'profile'])->name('admin.profile');
    
    Route::get('admin-profile-edit', [App\Http\Controllers\Admin\ProfileController::class, 'edit_profile'])->name('admin.profile.edit');
    
    Route::post('paiement-multiple', [App\Http\Controllers\Admin\TransactionsController::class, 'paiementMultiple'])->name('admin.paiement.multiple');
    Route::delete('delete-multiple', [App\Http\Controllers\Admin\TransactionsController::class, 'deleteMultiple'])->name('admin.payout.delete.multiple');

    Route::get('change-password', [App\Http\Controllers\Admin\AccountsController::class, 'changePassword'])->name('admin.change-password');
    Route::post('change-password', [App\Http\Controllers\Admin\AccountsController::class, 'updatePassword'])->name('admin.update-password');

});

Route::group(['prefix'=>'merchant', 'middleware'=>['merchant','auth','PreventBackHistory']], function(){

    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'merchant'])->name('merchant.dashboard');

    Route::get('bulk-payment', [App\Http\Controllers\Merchant\TransactionsController::class, 'payout'])->name('merchant.payout');
    Route::post('bulk-payment', [App\Http\Controllers\Merchant\TransactionsController::class, 'process_payout'])->name('merchant.import');

    Route::get('payment-history', [App\Http\Controllers\Merchant\TransactionsController::class, 'payout_logs'])->name('merchant.payout.history');

    Route::get('merchant-profile', [App\Http\Controllers\Merchant\ProfileController::class, 'profile'])->name('merchant.profile');
    
    Route::get('merchant-profile-edit', [App\Http\Controllers\Merchant\ProfileController::class, 'edit_profile'])->name('merchant.profile.edit');
    
    Route::post('paiement-multiple', [App\Http\Controllers\Merchant\TransactionsController::class, 'paiementMultiple'])->name('merchant.paiement.multiple');
    Route::delete('delete-multiple', [App\Http\Controllers\Merchant\TransactionsController::class, 'deleteMultiple'])->name('merchant.payout.delete.multiple');

    Route::get('change-password', [App\Http\Controllers\Merchant\AccountsController::class, 'changePassword'])->name('merchant.change-password');
    Route::post('change-password', [App\Http\Controllers\Merchant\AccountsController::class, 'updatePassword'])->name('merchant.update-password');

});

