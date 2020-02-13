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
 
Route::group(["namespace"=>"Api",'namespace' => 'Api'], function() {
    
    Route::post('login', 'UserController@login');
    Route::post('signup', 'UserController@signup');

    Route::get('categories', 'CategoryController@get');
    Route::get('products', 'ProductController@get');
    Route::get('vendors', 'UserController@getVendors');
   
    
});


Route::group(['middleware' => ['auth:api'],'namespace' => 'Api'],function() {

    Route::get('cart', 'CartController@getCart');
    Route::post('cart/add', 'CartController@addToCart');
    Route::post('order/create', 'OrderController@createOrder');

});
