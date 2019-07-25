<?php

use Illuminate\Http\Request;

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

Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth'
], function(){

    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::get('/email-confirmation/confirm', 'EmailConfirmationController@index');

    Route::group([
        'middleware' => 'auth:api'
    ], function(){

        Route::get('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@user');
    });
});

Route::group([
    'middleware' => 'auth:api'
], function(){

    Route::post('/settings/account/avatar', 'AvatarsController@store');
    Route::post('/settings/company/logo', 'CompanysLogosController@store');

    Route::patch('/settings/account', 'AccountSettingsController@update');
    Route::patch('/settings/password', 'PasswordSettingsController@update');
    Route::patch('/settings/company', 'CompaniesController@update');   

});


Route::get('/cargos', 'CargosController@index');
Route::get('/cargos/{cargo}', 'CargosController@show');

Route::get('/locations', 'LocationsController@index');
