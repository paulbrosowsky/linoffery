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
    Route::post('/login/refresh', 'AuthController@refresh');    
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
        
        Route::delete('/destroy', 'AuthController@destroy');
    });
});

Route::group([
    'middleware' => 'auth:api'
], function(){

    Route::get('/dashboard/tenders', 'TendersDashboardController@index');

    Route::get('/orders', 'OrdersController@index');
    Route::get('/orders/{order}', 'OrdersController@show')->name('order.show');
    Route::get('/orders/{order}/pdf', 'OrdersController@pdf');
    Route::patch('/orders/{order}/update', 'OrdersController@update');

    Route::get('/offers', 'OffersController@index');

    Route::post('/settings/account/avatar', 'AvatarsController@store');
    Route::post('/settings/company/logo', 'CompanysLogosController@store');
    Route::patch('/settings/account', 'AccountSettingsController@update');
    Route::patch('/settings/password', 'PasswordSettingsController@update');
    Route::patch('/settings/company', 'CompaniesController@update'); 
    Route::patch('/settings/newsletters', 'NotificationSettingsController@update'); 
    
    Route::get('/notifications', 'NotificationsController@index');
    Route::delete('/notifications', 'NotificationsController@destroyAll');
    Route::delete('/notifications/{notification}', 'NotificationsController@destroy');

    Route::get('/profiles/{company}', 'ProfilesController@show');
    Route::post('/profiles/{company}/comment', 'CommentsController@store');

    Route::delete('/comments/{comment}/destroy', 'CommentsController@destroy');

    Route::get('/invoices', 'InvoicesController@index'); 
    Route::get('/invoices/{invoice}/download', 'InvoicesController@download');
    
    Route::group([
        'middleware' => 'is-confirmed-completed'
    ], function(){

        Route::post('/tenders/store', 'TendersController@store');        

        Route::patch('/tenders/{tender}/update', 'TendersController@update');
        Route::patch('/tenders/{tender}/publish', 'TendersController@publish');
        Route::patch('/tenders/{tender}/cancel', 'TendersController@cancel');
        Route::post('/tenders/{tender}/offers/store', 'OffersController@store');
        Route::delete('/tenders/{tender}/destroy', 'TendersController@destroy');

        Route::post('/locations/store', 'LocationsController@store');       
        Route::patch('/locations/{location}/update', 'LocationsController@update');

        Route::post('/freights/store', 'FreightsController@store');
        Route::patch('/freights/{freight}/update', 'FreightsController@update');
       
        Route::delete('/offers/{offer}/destroy', 'OffersController@destroy');
        Route::patch('/offers/{offer}/update', 'OffersController@update');
    }); 
});

Route::get('/tenders', 'TendersController@index');
Route::get('/tenders/{tender}', 'TendersController@show');

Route::get('/categories', 'CategoriesController@index');
Route::get('/transport-types', 'TransportTypesController@index');

Route::get('/mollie/webhook', 'MollieWebhooksController@index')->name('mollie.webhook');
