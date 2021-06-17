<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/


/******      HOME      ******/
Route::get('home','HomeController@home');

/******      LOGIN      ******/
Route::get('login','LoginController@login');
Route::post('login','LoginController@checkCredentials');

/******      SIGNUP      ******/
Route::get('signup','SignupController@signup');
Route::post('signup','SignupController@addUser');

/******      USER AREA     ******/
Route::get('userarea','UserAreaController@userarea');
Route::post('userarea','UserAreaController@changePassword');
Route::post('userarea/bugReport','UserAreaController@addReport');
Route::get('logout','UserAreaController@logout');

/******      PRODOTTI      ******/
Route::get('products','ProductsController@products');
Route::post('products','ProductsController@purchase');

/******     CART      ******/
Route::get('cart','CartController@cart');
Route::post('cart','CartController@confirmedTransaction');

/******      HQ     ******/
Route::get('hq','HQController@hq');

/******      PARTNERS      ******/
Route::get('partners','PartnersController@partners');

/******      Fetch_transactionsDetails      ******/
Route::post('userarea/transactions','transactionsController@retrieve');

/******      Fetch_news ******/
Route::post('home/news','newsController@fetch');

/****** Fetch_productsInfo *****/
Route::get('products/info','pInfoController@retrieve');

?>