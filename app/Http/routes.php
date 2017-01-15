<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/




Route::auth();

Route::get('/', 'HomeController@index');

Route::get('/user/index', 'UserController@index');
Route::get('/user/add', 'UserController@add');
Route::post('/user/create', 'UserController@create');

Route::post('/store', 'HomeController@store');

//Route::any('{all}', function(){
//    return view('auth.login');
//})
//    ->where('all', '.*');

