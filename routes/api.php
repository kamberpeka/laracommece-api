<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Enums\RoleEnum;

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

Route::group(['namespace' => 'Api\V1', 'prefix' => 'v1', 'as' => 'api.v1.'], function() {

    Route::post('/login', [
        'uses' => 'AuthController@login',
        'as' => 'login'
    ]);

    Route::post('/register', [
        'uses' => 'AuthController@register',
        'as' => 'register'
    ]);

    Route::apiResource('products', 'ProductController')
        ->only(['index', 'store', 'update']);

    Route::get('/products/{slug}', [
        'uses' => 'ProductController@show',
        'as' => 'products.show'
    ]);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('/user', [
            'uses' => 'AuthController@user',
            'as' => 'user'
        ]);

        Route::middleware('role:' . RoleEnum::ADMIN )->group(function () {
            Route::post('/currencies/update-rates', [
                'uses' => 'CurrencyController@updateRates',
                'as' => 'currency.update.rates'
            ]);

        });

        Route::apiResource('addresses', 'AddressController');

    });

});
