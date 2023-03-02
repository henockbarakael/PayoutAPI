<?php

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
    Route::post('/v1/bulkpayment', 'App\Http\Controllers\API\CallbackController@getCallbackResponse');
});