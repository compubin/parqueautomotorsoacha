<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Default Controller
Route::get('/', 'PageController@index');
Route::get('/contact-us', 'PageController@contact');
Route::post('/contact', 'PageController@contact');
Route::post('page/submit', 'PageController@submit');
Route::get('posts', 'PageController@posts');
Route::get('posts/{any?}', 'PageController@posts');
Route::post('posts/comment', 'PageController@comment');
Route::get('posts/remove/{page}/{alias}/{id}', 'PageController@remove');

/* Auth & Profile */
Route::get('user/profile','UserController@getProfile');
Route::get('user/login','UserController@getLogin');
Route::get('user/register','UserController@getRegister');
Route::get('user/logout','UserController@getLogout');
Route::get('user/reminder','UserController@getReminder');
Route::get('user/reset/{any?}','UserController@getReset');
Route::get('user/reminder','UserController@getReminder');
Route::get('user/activation','UserController@getActivation');
// Social Login
Route::get('user/socialize/{any?}','UserController@socialize');
Route::get('user/autosocialize/{any?}','UserController@autosocialize');
//
Route::post('user/signin','UserController@postSignin');
Route::post('user/create','UserController@postCreate');
Route::post('user/saveprofile','UserController@postSaveprofile');
Route::post('user/savepassword','UserController@postSavepassword');
Route::post('user/doreset/{any?}','UserController@postDoreset');
Route::post('user/request','UserController@postRequest');

Route::get('/set_theme/{any}', 'PageController@set_theme');

Route::get('workflow/{id}/{any}','WorkflowController@show');

Route::get('/lang/{any}', 'PageController@lang');

include('pages.php');
Route::resource('api','ApiController');
Route::group(['middleware' => 'auth'], function () {	
	Route::get('loadNotif', 'PageController@loadNotif');
	Route::resource('dashboard','DashboardController');
	Route::post('dashboard/note','DashboardController@note');
	Route::post('dashboard/dropzone','DashboardController@dropzone');
	Route::resource('workflow','WorkflowController');

	include('module.php');

});

Route::group(['namespace' => 'Acore','middleware' => 'auth'], function () {

	include('root.php');
	include('builder.php');
	Route::resource('template','TemplateController');

});

