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
//Route::resource('Users', 'UserController');
Route::get('/user/index', 'UserController@index');
Route::get('/user/add', 'UserController@create');
Route::post('/user/create', 'UserController@store');
Route::post('/user/index', 'UserController@search');
Route::get('/user/show/{id}', 'UserController@show');
Route::get('/user/edit/{id}', 'UserController@edit');
Route::put('/user/edit/{id}', 'UserController@update');

//Group routing
Route::get('/user/group/index', 'GroupController@index');
Route::get('/user/group/add', 'GroupController@create');
Route::post('/user/group/create', 'GroupController@store');
Route::get('/user/group/edit/{id}', 'GroupController@edit');
Route::put('/user/group/edit/{id}', 'GroupController@update');
Route::get('/user/group/show/{id}', 'GroupController@showUser');

//IssueTypes routing
Route::get('/issue/type/index', 'IssueTypeController@index');
Route::get('/issue/type/add', 'IssueTypeController@create');
Route::post('/issue/type/create', 'IssueTypeController@store');
Route::get('/issue/type/edit/{id}', 'IssueTypeController@edit');
Route::put('/issue/type/edit/{id}', 'IssueTypeController@update');
Route::get('/issue/type/delete/{id}', 'IssueTypeController@destroy');

//IssuesPriority routing
Route::get('/issue/priority/index', 'IssuesPriorityController@index');
Route::get('/issue/priority/add', 'IssuesPriorityController@create');
Route::post('/issue/priority/create', 'IssuesPriorityController@store');
Route::get('/issue/priority/edit/{id}', 'IssuesPriorityController@edit');
Route::put('/issue/priority/edit/{id}', 'IssuesPriorityController@update');
Route::get('/issue/priority/delete/{id}', 'IssuesPriorityController@destroy');

//IssuesStatus routing
Route::get('/issue/status/index', 'IssueStatusController@index');
Route::get('/issue/status/add', 'IssueStatusController@create');
Route::post('/issue/status/create', 'IssueStatusController@store');
Route::get('/issue/status/edit/{id}', 'IssueStatusController@edit');
Route::put('/issue/status/edit/{id}', 'IssueStatusController@update');
Route::get('/issue/status/delete/{id}', 'IssueStatusController@destroy');

//Project routing
Route::get('/project/index', 'ProjectController@index');
Route::post('/project/index', 'ProjectController@search');
Route::get('/project/add', 'ProjectController@create');
Route::post('/project/create', 'ProjectController@store');
Route::get('/project/edit/{id}', 'ProjectController@edit');
Route::put('/project/edit/{id}', 'ProjectController@update');
Route::get('/project/delete/{id}', 'ProjectController@destroy');

//Issue routing
Route::get('/issue/index', 'IssueController@index');
Route::get('/issue/add', 'IssueController@create');
Route::post('/issue/create', 'IssueController@store');
Route::get('/issue/edit/{id}', 'IssueController@edit');
Route::put('/issue/edit/{id}', 'IssueController@update');
Route::get('/issue/delete/{id}', 'IssueController@destroy');

//Sprint routing
Route::get('/sprint/index', 'SprintController@index');
Route::get('/sprint/add', 'SprintController@create');
Route::post('/sprint/create', 'SprintController@store');
Route::get('/sprint/edit/{id}', 'SprintController@edit');
Route::put('/sprint/edit/{id}', 'SprintController@update');
Route::get('/sprint/delete/{id}', 'SprintController@destroy');

//Board routing
Route::get('/board/index', 'BoardController@index');
Route::get('/board/add', 'BoardController@create');
Route::post('/board/create', 'BoardController@store');
Route::get('/board/edit/{id}', 'BoardController@edit');
Route::put('/board/edit/{id}', 'BoardController@update');
Route::get('/board/delete/{id}', 'BoardController@destroy');

Route::post('/store', 'HomeController@store');

//Route::any('{all}', function(){
//    return view('auth.login');
//})
//    ->where('all', '.*');

