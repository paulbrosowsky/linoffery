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
    Route::post('/password/email', 'ForgotPasswordController@index');
    Route::post('/password/reset', 'ForgotPasswordController@update');
    Route::get('/email-confirmation/confirm', 'EmailConfirmationController@index'); 
      

    Route::group([
        'middleware' => 'auth:api'
    ], function(){

        Route::get('/logout', 'AuthController@logout');
        Route::get('/user', 'AuthController@user');
        Route::get('/email-confirmation/email', 'EmailConfirmationController@update');  
    });
});

Route::group([
    'middleware' => 'auth:api'
], function(){

    Route::get('/dashboard/tenders', 'TendersDashboardController@index');

    Route::post('/settings/account/avatar', 'AvatarsController@store');
    Route::post('/settings/company/logo', 'CompanysLogosController@store');

    Route::patch('/settings/account', 'AccountSettingsController@update');
    Route::patch('/settings/password', 'PasswordSettingsController@update');
    Route::patch('/settings/company', 'CompaniesController@update');  
    
    Route::group([
        'middleware' => 'is-confirmed-completed'
    ], function(){

        Route::post('/tenders/store', 'TendersController@store');
        Route::post('/locations/store', 'LocationsController@store');
        Route::post('/freights/store', 'FreightsController@store');

        Route::patch('/tenders/{tender}/update', 'TendersController@update');
        Route::patch('/tenders/{tender}/publish', 'TendersController@publish');
        Route::patch('/locations/{location}/update', 'LocationsController@update');
        Route::patch('/freights/{freight}/update', 'FreightsController@update');
    }); 
});


Route::get('/tenders', 'TendersController@index');
Route::get('/tenders/{tender}', 'TendersController@show');

Route::get('/categories', 'CategoriesController@index');

// Route::get('/locations', 'LocationsController@index');
