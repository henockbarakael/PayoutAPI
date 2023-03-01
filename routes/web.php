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

// ----------------------------- lock screen --------------------------------//
Route::get('lock_screen', [App\Http\Controllers\LockScreen::class, 'lockScreen'])->name('lock_screen');
Route::post('unlock', [App\Http\Controllers\LockScreen::class, 'unlock'])->name('unlock');

// ------------------------------ register ---------------------------------//
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'storeUser'])->name('register.store');
Route::post('/verify', [App\Http\Controllers\Auth\RegisterController::class, 'verify'])->name('verify.post');

// ----------------------------- forget password ----------------------------//
Route::get('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'getEmail'])->name('forget-password');
Route::post('forget-password', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'postEmail'])->name('forget-password');

// ----------------------------- reset password -----------------------------//
Route::get('reset-password/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'getPassword']);
Route::post('reset-password', [App\Http\Controllers\Auth\ResetPasswordController::class, 'updatePassword']);


Route::group(['prefix'=>'admin', 'middleware'=>['admin','auth','PreventBackHistory']], function(){
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'admin'])->name('admin.dashboard');
    Route::get('add-merchant', [App\Http\Controllers\Admin\UsermanagementController::class, 'merchant_form'])->name('admin.merchant.form');
    Route::post('add-merchant', [App\Http\Controllers\Admin\UsermanagementController::class, 'add_merchant'])->name('admin.merchant.add');
    Route::get('list-merchant', [App\Http\Controllers\Admin\UsermanagementController::class, 'list_merchant'])->name('admin.merchant.list');

    Route::get('add-user', [App\Http\Controllers\Admin\UsermanagementController::class, 'user_form'])->name('admin.user.form');
    Route::post('add-user', [App\Http\Controllers\Admin\UsermanagementController::class, 'add_user'])->name('admin.user.add');
    Route::get('list-user', [App\Http\Controllers\Admin\UsermanagementController::class, 'list_user'])->name('admin.user.list');

    Route::get('add-transaction', [App\Http\Controllers\Admin\TransactionsController::class, 'index'])->name('admin.transaction.form');
    Route::post('add-transaction', [App\Http\Controllers\Admin\TransactionsController::class, 'store'])->name('admin.transaction.add');
    Route::get('list-transaction', [App\Http\Controllers\Admin\TransactionsController::class, 'list_transaction'])->name('admin.transaction.list');

    Route::get('topup-wallet', [App\Http\Controllers\Admin\WalletController::class, 'index'])->name('admin.wallet.form');
    Route::post('topup-wallet', [App\Http\Controllers\Admin\WalletController::class, 'store'])->name('admin.wallet.topup');
    Route::get('list-wallet', [App\Http\Controllers\Admin\WalletController::class, 'list_wallet'])->name('admin.wallet.list');

    Route::get('payout', [App\Http\Controllers\Admin\TransactionsController::class, 'payout'])->name('admin.payout');
    Route::get('payout-test', [App\Http\Controllers\Admin\TransactionsController::class, 'payout_test'])->name('admin.payout.test');
    Route::get('payout-history-report', [App\Http\Controllers\Admin\TransactionsController::class, 'payout_logs'])->name('admin.payout.history');
    Route::get('payout-history-report-test', [App\Http\Controllers\Admin\TransactionsController::class, 'payout_test_logs'])->name('admin.payout.history.test');
    Route::post('payout', [App\Http\Controllers\Admin\TransactionsController::class, 'process_payout'])->name('admin.import');
    Route::post('import_test', [App\Http\Controllers\Admin\TransactionsController::class, 'process_payout_test'])->name('admin.import.test');
    Route::post('submit_checked', [App\Http\Controllers\Admin\TransactionsController::class, 'submit_checked'])->name('admin.submit_checked');
    Route::post('paiement/{id}', [App\Http\Controllers\Admin\TransactionsController::class, 'paiement'])->name('admin.paiement');
    Route::delete('delete-payout/{id}', [App\Http\Controllers\Admin\TransactionsController::class, 'delete_payout'])->name('admin.paiement.delete');
    Route::post('paiement-multiple', [App\Http\Controllers\Admin\TransactionsController::class, 'paiementMultiple'])->name('admin.paiement.multiple');
    Route::delete('delete-multiple', [App\Http\Controllers\Admin\TransactionsController::class, 'deleteMultiple'])->name('admin.payout.delete.multiple');



    Route::post('remboursement_submit_checked', [App\Http\Controllers\RemboursementController::class, 'submit_checked'])->name('admin.remboursement.submit_checked');
    Route::post('remboursement/{id}', [App\Http\Controllers\RemboursementController::class, 'remboursementID'])->name('admin.remboursement');
    Route::delete('delete-remboursement/{id}', [App\Http\Controllers\RemboursementController::class, 'delete_remboursement'])->name('admin.remboursement.delete');

    Route::get('remboursement', [App\Http\Controllers\RemboursementController::class, 'remboursement'])->name('admin.remboursement');
    Route::get('remboursement-history-report', [App\Http\Controllers\RemboursementController::class, 'remboursement_logs'])->name('admin.remboursement.history');
    Route::post('remboursement', [App\Http\Controllers\RemboursementController::class, 'process_remboursement'])->name('admin.remboursement.import');

    Route::post('remboursement-multiple', [App\Http\Controllers\RemboursementController::class, 'paiementMultiple'])->name('admin.remboursement.multiple');
    Route::delete('remboursement-delete-multiple', [App\Http\Controllers\RemboursementController::class, 'deleteMultiple'])->name('admin.remboursement.delete.multiple');





    Route::post('/upload', [App\Http\Controllers\UploadController::class, 'upload'])->name('upload');
});

Route::group(['prefix'=>'merchant', 'middleware'=>['merchant','auth','PreventBackHistory']], function(){
    Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'merchant'])->name('merchant.dashboard');
    Route::get('add-merchant', [App\Http\Controllers\Merchant\UsermanagementController::class, 'merchant_form'])->name('merchant.merchant.form');
    Route::post('add-merchant', [App\Http\Controllers\Merchant\UsermanagementController::class, 'add_merchant'])->name('merchant.merchant.add');
    Route::get('list-merchant', [App\Http\Controllers\Merchant\UsermanagementController::class, 'list_merchant'])->name('merchant.merchant.list');

    Route::get('add-user', [App\Http\Controllers\Merchant\UsermanagementController::class, 'user_form'])->name('merchant.user.form');
    Route::post('add-user', [App\Http\Controllers\Merchant\UsermanagementController::class, 'add_user'])->name('merchant.user.add');
    Route::get('list-user', [App\Http\Controllers\Merchant\UsermanagementController::class, 'list_user'])->name('merchant.user.list');

    Route::get('add-transaction', [App\Http\Controllers\Merchant\TransactionsController::class, 'index'])->name('merchant.transaction.form');
    Route::post('add-transaction', [App\Http\Controllers\Merchant\TransactionsController::class, 'store'])->name('merchant.transaction.add');
    Route::get('list-transaction', [App\Http\Controllers\Merchant\TransactionsController::class, 'list_transaction'])->name('merchant.transaction.list');

    Route::get('topup-wallet', [App\Http\Controllers\Merchant\WalletController::class, 'index'])->name('merchant.wallet.form');
    Route::post('topup-wallet', [App\Http\Controllers\Merchant\WalletController::class, 'store'])->name('merchant.wallet.topup');
    Route::get('list-wallet', [App\Http\Controllers\Merchant\WalletController::class, 'list_wallet'])->name('merchant.wallet.list');

    Route::get('payout', [App\Http\Controllers\Merchant\TransactionsController::class, 'payout'])->name('merchant.payout');
    Route::get('payout-test', [App\Http\Controllers\Merchant\TransactionsController::class, 'payout_test'])->name('merchant.payout.test');
    Route::get('payout-history-report', [App\Http\Controllers\Merchant\TransactionsController::class, 'payout_logs'])->name('merchant.payout.history');
    Route::get('payout-history-report-test', [App\Http\Controllers\Merchant\TransactionsController::class, 'payout_test_logs'])->name('merchant.payout.history.test');
    Route::post('payout', [App\Http\Controllers\Merchant\TransactionsController::class, 'process_payout'])->name('merchant.import');
    Route::post('import_test', [App\Http\Controllers\Merchant\TransactionsController::class, 'process_payout_test'])->name('merchant.import.test');
    Route::post('submit_checked', [App\Http\Controllers\Merchant\TransactionsController::class, 'submit_checked'])->name('merchant.submit_checked');
    Route::post('paiement/{id}', [App\Http\Controllers\Merchant\TransactionsController::class, 'paiement'])->name('merchant.paiement');
    Route::delete('delete-payout/{id}', [App\Http\Controllers\Merchant\TransactionsController::class, 'delete_payout'])->name('merchant.paiement.delete');
    Route::post('paiement-multiple', [App\Http\Controllers\Merchant\TransactionsController::class, 'paiementMultiple'])->name('merchant.paiement.multiple');
    Route::delete('delete-multiple', [App\Http\Controllers\Merchant\TransactionsController::class, 'deleteMultiple'])->name('merchant.payout.delete.multiple');
    Route::post('remboursement_submit_checked', [App\Http\Controllers\RemboursementController::class, 'submit_checked'])->name('merchant.remboursement.submit_checked');
    Route::post('remboursement/{id}', [App\Http\Controllers\RemboursementController::class, 'remboursementID'])->name('merchant.remboursement');
    Route::delete('delete-remboursement/{id}', [App\Http\Controllers\RemboursementController::class, 'delete_remboursement'])->name('merchant.remboursement.delete');

    Route::get('remboursement', [App\Http\Controllers\RemboursementController::class, 'remboursement'])->name('merchant.remboursement');
    Route::get('remboursement-history-report', [App\Http\Controllers\RemboursementController::class, 'remboursement_logs'])->name('merchant.remboursement.history');
    Route::post('remboursement', [App\Http\Controllers\RemboursementController::class, 'process_remboursement'])->name('merchant.remboursement.import');

    Route::post('remboursement-multiple', [App\Http\Controllers\RemboursementController::class, 'paiementMultiple'])->name('merchant.remboursement.multiple');
    Route::delete('remboursement-delete-multiple', [App\Http\Controllers\RemboursementController::class, 'deleteMultiple'])->name('merchant.remboursement.delete.multiple');

    Route::post('/upload', [App\Http\Controllers\UploadController::class, 'upload'])->name('upload');
});

// Route::group(['prefix'=>'merchant', 'middleware'=>['merchant','auth','PreventBackHistory']], function(){
//     Route::get('dashboard', [App\Http\Controllers\HomeController::class, 'merchant'])->name('merchant.dashboard');
//     Route::get('add-merchant', [App\Http\Controllers\Merchant\UsermanagementController::class, 'merchant_form'])->name('submerchant.form');
//     Route::post('add-merchant', [App\Http\Controllers\Merchant\UsermanagementController::class, 'add_merchant'])->name('submerchant.add');
//     Route::get('list-merchant', [App\Http\Controllers\Merchant\UsermanagementController::class, 'list_merchant'])->name('submerchant.list');
//     Route::get('list-transaction', [App\Http\Controllers\TransactionController::class, 'list_transaction'])->name('transaction.list');
// });

