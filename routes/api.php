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

Route::post('/register', 'Auth\RegisterController@create');
Route::post('/login', 'Auth\LoginController@login');
Route::resource('/product','ProductController');
Route::resource('/items','InvoiceItemsController');
Route::get('/mystore','ProductController@getMyStore');
Route::get('/userstore/{user_account}','ProductController@getSellerStore');
Route::resource('/rating','RatingController');
Route::post('/itemfeedback','RatingController@ItemfFeedBack');


Route::resource('/invoice','InvoicesController');
