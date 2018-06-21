<?php
//-------------------------------------------------------------------------
/* Start Module Routes */


Route::get('builder','BuilderController@index');
Route::get('builder/create','BuilderController@getCreate');
Route::get('builder/rebuild/{any}','BuilderController@getRebuild');
Route::get('builder/build/{any}','BuilderController@getBuild');
Route::get('builder/config/{any}','BuilderController@getConfig');
Route::get('builder/sql/{any}','BuilderController@getSql');
Route::get('builder/table/{any}','BuilderController@getTable');
Route::get('builder/form/{any}','BuilderController@getForm');
Route::get('builder/formdesign/{any}','BuilderController@getFormdesign');
Route::get('builder/subform/{any}','BuilderController@getSubform');
Route::get('builder/subformremove/{any}','BuilderController@getSubformremove');
Route::get('builder/sub/{any}','BuilderController@getSub');
Route::get('builder/removesub','BuilderController@getRemovesub');
Route::get('builder/permission/{any}','BuilderController@getPermission');
Route::get('builder/source/{any}','BuilderController@getSource');
Route::get('builder/combotable','BuilderController@getCombotable');
Route::get('builder/combotablefield','BuilderController@getCombotablefield');
Route::get('builder/editform/{any?}','BuilderController@getEditform');
Route::get('builder/destroy/{any?}','BuilderController@getDestroy');
Route::get('builder/conn/{any?}','BuilderController@getConn');
Route::get('builder/code/{any?}','BuilderController@getCode');
Route::get('builder/duplicate/{any?}','BuilderController@getDuplicate');
Route::get('builder/template/{any}','BuilderController@getTemplate');
Route::get('builder/preview/{table}','BuilderController@preview');
Route::get('builder/attach/{table}','BuilderController@attachTemplate');
/* POST METHODE */
Route::post('builder/create','BuilderController@postCreate');
Route::post('builder/saveconfig/{any}','BuilderController@postSaveconfig');
Route::post('builder/savesetting/{any}','BuilderController@postSavesetting');
Route::post('builder/savesql/{any}','BuilderController@postSavesql');
Route::post('builder/savetable/{any}','BuilderController@postSavetable');
Route::post('builder/saveform/{any}','BuilderController@postSaveForm');
Route::post('builder/savesubform/{any}','BuilderController@postSavesubform');
Route::post('builder/formdesign/{any}','BuilderController@postFormdesign');
Route::post('builder/savepermission/{any}','BuilderController@postSavePermission');
Route::post('builder/savesub/{any}','BuilderController@postSaveSub');
Route::post('builder/dobuild/{any}','BuilderController@postDobuild');
Route::post('builder/source/{any}','BuilderController@postSource');
Route::post('builder/install','BuilderController@postInstall');
Route::post('builder/package','BuilderController@postPackage');
Route::post('builder/dopackage','BuilderController@postDopackage');
Route::post('builder/saveformfield/{any?}','BuilderController@postSaveformfield');
Route::post('builder/conn/{any?}','BuilderController@postConn');
Route::post('builder/code/{any?}','BuilderController@postCode');
Route::post('builder/duplicate/{any?}','BuilderController@postDuplicate');
Route::post('builder/savetemplate/{any?}','BuilderController@savetemplate');


//-------------------------------------------------------------------------
/* Start  Config Routes */

/* End  Config Routes */



