<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/phpinfo', function () {
    return phpinfo();
});

Route::get('/migrate', 'migrationController@getOrsDatas');


Route::get('/uploadfile','UploadFileController@index');
Route::get('/test','UploadFileController@test');
Route::post('/uploadfile','UploadFileController@showUploadFile');
Route::post('/importData','UploadFileController@importData');
Route::post('/listIndcators','QueryDatabaseController@getFKIndicatorList');
Route::post('/getTypeHeaders','QueryDatabaseController@getTypeHeaders');
Route::post('/getHeaders','QueryDatabaseController@getHeaders');