<?php

use Illuminate\Http\Request;
use \App\Entities\Product;
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
Route::get('/getProfile','Auth\ProfileController@getProfile');
Route::post('/updateProfile','Auth\ProfileController@updateProfile');

// Route::group(['namespace' => 'Auth'], function(){
	
// });
Route::resource('/product','ProductController');
Route::get('/fetchRecommandProducts', 'ProductController@fetchRecommandProducts');
Route::resource('/product_school','ProductController');
Route::get('/mystore','ProductController@getMyStore');
Route::get('/userstore/{user_account}','ProductController@getSellerStore');




Route::get('/schoolist','ProductController@getSchoolList');
Route::get('/categorylist','ProductController@getCategoryList');
Route::get('/sub_categorylist','ProductController@getSubCategoryList');

Route::resource('/items','InvoiceItemsController');
Route::resource('/rating','RatingController');
Route::post('/itemfeedback','RatingController@ItemfFeedBack');
Route::resource('/question','ProductQuestionsController');
Route::resource('/invoice','InvoicesController');
Route::post('/addChatUser','ChatController@addChatUser');
Route::get('/getChatUser','ChatController@getChatUser');
Route::get('/getChatContent','ChatController@getChatContent');
Route::post('/postMessage','ChatController@postMessage');
Route::get('/Getnotify','NotificationController@Getnotify');
Route::get('/MarkRead','NotificationController@MarkRead');
Route::get('/ReadChannel','ChatController@ReadChannel');

Route::post('/changeProfile','Auth\LoginController@changeProfile');

Route::get('/getunread_message','ChatController@GetUnreadMessage');
Route::get('/getemail',function(){
	dd(\DB::table('users')->paginate(5));
});
Route::get('/a',function(){
	dd(\DB::table('users')->paginate(5));
});

// auth
Route::post('/auth/refresh',['uses'=>'Auth\AuthController@refresh','middleware'=>'jwt.auth']);