<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\ComissionController;
use App\Http\Controllers\API\InstitutionController;
use App\Http\Controllers\API\InstitutionUserController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\MerchantController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\api\v1\FreshPayController;
use App\Http\Controllers\API\WalletController;
use App\Http\Controllers\API\WalletHistoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::post('v1/register', [RegisterController::class, 'register']);
// Route::post('v1/login', [LoginController::class, 'login']);

Route::middleware('auth:api')->group( function () {
    Route::resource('v1/transaction', TransactionController::class);
    Route::resource('v1/institution', InstitutionController::class);
    Route::resource('v1/institution/users', InstitutionUserController::class);
    Route::resource('v1/merchant/create', MerchantController::class);
    Route::resource('v1/comission', ComissionController::class);
    Route::resource('v1/account', AccountController::class);
    Route::resource('v1/wallet', WalletController::class);
    Route::resource('v1/wallet-history', WalletHistoryController::class);
    Route::post('v1/csv/upload', [FreshPayController::class, 'payout']);

});