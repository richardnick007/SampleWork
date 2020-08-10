<?php

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

//Authentication route 
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::get('user', 'UserController@getAuthenticatedUser');
// Make Transfer Route
    Route::post('/pay', 'PaymentController@payviacard');
// OTP Validation route
    Route::post('/payment-validate', 'PaymentController@validatePayment');
// GetUsersTransaction Route
    Route::get('getTransactions/{email}', 'PaymentController@getTransactions');
// SearchforUser Route
    Route::get('searchTransactions/{email}', 'PaymentController@@searchTransactions');
});
