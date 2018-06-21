<?php
Route::get('secure','SecureController@index');
Route::get('secure/users','SecureController@users');
Route::post('secure/users', 'SecureController@users');

Route::get('secure/groups','SecureController@groups');
Route::post('secure/groups', 'SecureController@groups');

Route::get('secure/blast','SecureController@blast');
Route::post('secure/doblast', 'SecureController@doblast');

Route::get('secure/pages','SecureController@pages');
Route::post('secure/pages', 'SecureController@pages');

Route::get('secure/posts','SecureController@posts');
Route::post('secure/posts', 'SecureController@posts');

Route::get('secure/content/{any}','SecureController@content');
Route::post('secure/content/{any}','SecureController@content');


Route::get('notification','SecureController@notification');
Route::post('notification', 'SecureController@notification');

Route::get('secure/about','SecureController@about');

Route::get('root','RootController@index');
Route::get('root/menu','RootController@menu');
Route::get('root/menu_icon','RootController@menu_icon');
Route::get('root/menu/{any}','RootController@menu');
Route::post('root/save_order', 'RootController@save_order');
Route::post('root/save_menu', 'RootController@save_menu');
Route::get('root/delete_menu/{any}', 'RootController@delete_menu');

Route::get('root/database','RootController@database');
Route::post('root/database', 'RootController@database');

Route::get('root/code','RootController@code');
Route::get('root/code_edit','RootController@code_edit');
Route::post('root/code_source/{any}', 'RootController@code_source');
Route::post('root/code_save', 'RootController@code_save');

Route::get('root/folder','RootController@folder');
Route::post('root/folder', 'RootController@folder');

Route::get('root/api','RootController@api');
Route::post('root/api', 'RootController@api');

Route::get('root/activity','RootController@activity');
Route::post('root/activity', 'RootController@activity');

Route::get('root/log','RootController@log');

Route::get('root/config','RootController@config');
Route::get('root/email','RootController@email');
Route::post('root/save_config','RootController@save_config');
Route::post('root/save_email','RootController@save_email');

Route::get('root/builder','RootController@builder');
Route::post('root/builder', 'RootController@builder');

Route::resource('root/database','DatabaseController');
Route::resource('root/form','FormController');
Route::resource('root/dropzone','DropzoneController');


Route::get('root/widgets','RootController@widgets');
Route::post('root/widgets','RootController@widgets');

Route::get('root/version','RootController@version');
Route::post('root/version','RootController@version');
