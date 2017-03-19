<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group(['middleware' => 'cors:api'], function () {

//    Route::get('/consultant_registration', 'Api\ConsultantRegistrationController@index' );
//    Route::post('/consultant_registration', 'Api\ConsultantRegistrationController@store' );
//    Route::get('/consultant_registration/{consultant?}', 'Api\ConsultantRegistrationController@show' );
    Route::resource('/consultant_registration', 'Api\ConsultantRegistrationController');
    Route::get('/consultant_registration_insert_fake_data', 'Api\ConsultantRegistrationController@insert_fake_data' );

    Route::resource('/customers', 'Api\CustomersController');

    // Begin Authentication Api
    Route::post('/authenticate', 'Api\AuthenticateController@authenticate');
    Route::get('/authenticate/user', 'Api\AuthenticateController@getAuthenticatedUser');
    Route::post('/signup', 'Api\AuthenticateController@signup');
    // End Authentication Api

});