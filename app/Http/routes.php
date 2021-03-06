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
Route::get('/presentation', 'HomeController@presentation');

Route::group(['middleware' => 'group:Administrator,PM'], function () {
    //Board routing
    Route::get('/board/index', 'BoardController@index');
    Route::get('/board/add', 'BoardController@create');
    Route::post('/board/create', 'BoardController@store');
    Route::get('/board/edit/{id}', 'BoardController@edit');
    Route::put('/board/edit/{id}', 'BoardController@update');
    Route::get('/board/delete/{id}', 'BoardController@destroy');

    //Group routing
    Route::get('/user/group/index', 'GroupController@index');
    Route::get('/user/group/add', 'GroupController@create');
    Route::post('/user/group/create', 'GroupController@store');
    Route::get('/user/group/edit/{id}', 'GroupController@edit');
    Route::put('/user/group/edit/{id}', 'GroupController@update');
    Route::get('/user/group/show/{id}', 'GroupController@showUser');


    //Issue routing
    Route::get('/issue/index', 'IssueController@index');
    Route::get('/issue/delete/{id}', 'IssueController@destroy');

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

    //IssueTypes routing
    Route::get('/issue/type/index', 'IssueTypeController@index');
    Route::get('/issue/type/add', 'IssueTypeController@create');
    Route::post('/issue/type/create', 'IssueTypeController@store');
    Route::get('/issue/type/edit/{id}', 'IssueTypeController@edit');
    Route::put('/issue/type/edit/{id}', 'IssueTypeController@update');
    Route::get('/issue/type/delete/{id}', 'IssueTypeController@destroy');

    //Project routing
    Route::get('/project/index','ProjectController@index');
    Route::post('/project/index', 'ProjectController@search');
    Route::get('/project/add', 'ProjectController@create');
    Route::post('/project/create', 'ProjectController@store');
    Route::get('/project/delete/{id}', 'ProjectController@destroy');

    //Sprint routing
    Route::get('/sprint/index', 'SprintController@index');

    //User routing
    Route::get('/user/index', 'UserController@index');
    Route::post('/user/index', 'UserController@search');
    Route::get('/user/add', 'UserController@create');
    Route::post('/user/create', 'UserController@store');
    Route::get('/user/edit/{id}', 'UserController@edit');
    Route::put('/user/edit/{id}', 'UserController@update');

});

//Project routing
Route::get('/project/{id}/view', 'ProjectController@view');
Route::get('/project/{key}/board/{id}/backlog', 'ProjectController@backlog');
Route::put('/project/{key}/board/{id}/backlog', 'ProjectController@refresh');
Route::get('/project/{key}/board/{i}/sprint/{id}', 'ProjectController@showSprint');
Route::put('/project/{key}/board/{i}/sprint/{id}', 'ProjectController@updateSprint');
Route::put('/project/issue/{id}', 'ProjectController@saveWorkLog');
Route::get('/project/edit/{id}', 'ProjectController@edit');
Route::put('/project/edit/{id}', 'ProjectController@update');

//Issue routing
Route::get('/issue/add/{key}', 'IssueController@create');
Route::post('/issue/create/{key}', 'IssueController@store');
Route::post('/issue/create/{key}', 'IssueController@modalStore');
Route::get('/project/{key?}/issue/{id}/view', 'IssueController@view');
Route::get('/project/{key}/issue/{id}/edit', 'IssueController@edit');
Route::put('/project/{key}/issue/{id}/edit', 'IssueController@update');

// Comment
Route::get('/issue/comment/index/{id}', 'IssueController@addComment');
Route::put('/issue/comment/index/{id}', 'IssueController@saveComment');
Route::get('/issue/comment/edit/{id}', 'IssueController@editComment');
Route::put('/issue/comment/edit/{id}', 'IssueController@updateComment');
Route::get('/issue/comment/delete/{id}', 'IssueController@deleteComment');
// WorkLog
Route::get('/issue/workLog/index/{id}', 'IssueController@addWorkLog');
Route::put('/issue/workLog/index/{id}', 'IssueController@saveWorkLog');
Route::get('/issue/workLog/edit/{id}', 'IssueController@editWorkLog');
Route::put('/issue/workLog/edit/{id}', 'IssueController@updateWorkLog');
Route::get('/issue/workLog/delete/{id}', 'IssueController@deleteWorkLog');
// File
Route::get('/issue/file/index/{id}', 'IssueController@addFile');
Route::put('/issue/file/index/{id}', 'IssueController@saveFile');
Route::get('/issue/file/delete/{filename}', ['as'=>'upload_delete', 'uses'=>'IssueController@deleteFile']);

//Sprint routing

Route::get('/sprint/add/project/{key}/board/{id}', 'SprintController@create');
Route::post('/sprint/create/project/{key}/board/{id}', 'SprintController@store');
Route::get('/sprint/edit/{id}/board/{i}', 'SprintController@edit');
Route::get('/sprint/modalEdit/{id}', 'SprintController@modalEdit', function(){
    return response()->header('Content-Type', 'application/json');
});
Route::put('/sprint/modalEdit/{id}', 'SprintController@modalUpdate');
Route::put('/sprint/edit/{id}/board/{i}', 'SprintController@update');
Route::get('/sprint/{id}/makeActive', 'SprintController@makeStatusIsActive');
Route::get('/sprint/{id}/makeFinish', 'SprintController@makeStatusIsFinish');
Route::get('/sprint/delete/{id}', 'SprintController@destroy');

//User routing
Route::get('/user/show/{id}', 'UserController@show');

Route::post('/store', 'HomeController@store');

Route::any('{all}', function(){
    return view('auth.login');
})
    ->where('all', '.*');

