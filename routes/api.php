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

});
Route::post('/transfer', 'TransactionController@payViaUssd');
// OTP Validation route
    Route::post('/validation', 'TransactionController@validatePayment');
// GetUsersTransaction Route
    Route::get('Transactions', 'TransactionController@Transactions');
// SearchforUser Route
    Route::get('search/user/{email}', 'TransactionController@search');
// Make Transfer Route
