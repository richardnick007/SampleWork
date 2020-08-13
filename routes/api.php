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

    Route::post('/transfer', 'TransactionController@transfer');
    // GetUsersTransaction Route
    Route::get('transactions', 'TransactionController@getTransaction');
    // SearchforUser Route
    Route::get('transfers/{name}', 'TransactionController@search');
    // Make Transfer Route
});
Route::fallback(function(){
    return response()->json([
        'message' => 'Page Not Found.'], 404);
});