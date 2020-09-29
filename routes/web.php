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
Route::get('/indicateurs', 'indicateurController@liste');
Route::get('/indicateur/{id}', 'indicateurController@show_view_consulter');
Route::get('/edit/indicateur/{id}', 'indicateurController@show_view_modifier');
Route::get('/add/indicateur', 'indicateurController@show_view_ajouter');
Route::get('/delete/indicateur/{id}', 'indicateurController@show_view_delete');

Route::get('/uploadfile','UploadFileController@index');
Route::get('/test','UploadFileController@test');

Route::get('/subcategories', 'kf_subcategoryController@liste');
Route::get('/subcategory/{id}', 'kf_subcategoryController@show_view_consulter');
Route::get('/edit/subcategory/{id}', 'kf_subcategoryController@show_view_modifier');
Route::get('/add/subcategory', 'kf_subcategoryController@show_view_ajouter');
Route::get('/delete/subcategory/{id}', 'kf_subcategoryController@show_view_delete');

Route::get('/categories', 'kf_categController@liste');
Route::get('/category/{id}', 'kf_categController@show_view_consulter');
Route::get('/edit/category/{id}', 'kf_categController@show_view_modifier');
Route::get('/add/category', 'kf_categController@show_view_ajouter');
Route::get('/delete/category/{id}', 'kf_categController@show_view_delete');

Route::get('/headers', 'headerController@liste');
Route::get('/header/{id}', 'headerController@show_view_consulter');
Route::get('/delete/header/{id}', 'headerController@show_view_delete');

Route::get('/database','localDataController@show_view_database');
Route::get('/confirmimport/{element}','localDataController@show_view_confirm_import');
Route::get('/accessimport','localDataController@show_view_access_import');
Route::get('/accessmanage','localDataController@show_view_access_manage');
Route::get('/import','localDataController@show_view_import');
Route::get('/import/caseloads','localDataController@import_caseloads');
Route::get('/import/informSahel','localDataController@import_inform_sahel');
Route::get('/import/idps','localDataController@import_internally_displaced_person');
Route::get('/import/nutrition','localDataController@import_nutrition');
Route::get('/import/ch','localDataController@import_cadre_harmonise');
Route::get('/import/fs','localDataController@import_food_security');
Route::get('/import/disp','localDataController@import_displacement');

Route::get('/zones','zoneController@liste');
Route::get('/managezones','zoneController@manageliste');
Route::get('/analyserzone/{id}', 'zoneController@show_view_analyser');
Route::get('/zone/charts/{id}', 'zoneController@show_view_charts');
Route::get('/adavancedanalysis', 'zoneController@show_view_analyser_avance');
Route::get('/zone/{id}', 'zoneController@show_view_consulter');
Route::get('/managezone/{id}', 'zoneController@show_view_manage_consulter');
Route::get('/edit/zone/{id}', 'zoneController@show_view_modifier');
Route::get('/add/zone', 'zoneController@show_view_ajouter');
Route::get('/delete/zone/{id}', 'zoneController@show_view_delete');

Route::get('/localites','localiteController@liste');
Route::get('/localite/{id}', 'localiteController@show_view_consulter');
Route::get('/localite/charts/{id}', 'localiteController@show_view_charts');
Route::get('/analyserlocalite/{id}', 'localiteController@show_view_analyser');
Route::get('/managelocalite/{id}', 'localiteController@show_view_manage_consulter');
Route::get('/edit/localite/{id}', 'localiteController@show_view_modifier');
Route::get('/add/localite/{id}', 'localiteController@show_view_ajouter');
Route::get('/delete/localite/{id}', 'localiteController@show_view_delete');



//LOGIN
Route::get('/logout', function () {
    request()->session()->flush();
    return redirect("/database");
});


//ROBOTS
Route::get('/getAPIDatas','robotController@getAPIDatas');
Route::get('/delete/all','outilController@deleteall');



//POSTS
Route::post('/uploadfile','UploadFileController@showUploadFile');
Route::post('/importData','UploadFileController@importData');
Route::post('/listIndcators','QueryDatabaseController@getFKIndicatorList');
Route::post('/getTypeHeaders','QueryDatabaseController@getTypeHeaders');
Route::post('/getHeaders','QueryDatabaseController@getHeaders');
Route::post('/getDisaggregations','QueryDatabaseController@getDisaggregations');

Route::post('/update/indicateur','indicateurController@update');
Route::post('/add/indicateur','indicateurController@add');
Route::post('/delete/indicateur','indicateurController@delete');
Route::post('/massdelete/indicateur','indicateurController@massdelete');

Route::post('/update/subcategory','kf_subcategoryController@update');
Route::post('/add/subcategory','kf_subcategoryController@add');
Route::post('/delete/subcategory','kf_subcategoryController@delete');
Route::post('/massdelete/subcategory','kf_subcategoryController@massdelete');

Route::post('/update/category','kf_categController@update');
Route::post('/add/category','kf_categController@add');
Route::post('/delete/category','kf_categController@delete');
Route::post('/massdelete/category','kf_categController@massdelete');
Route::post('/massdelete/subcategory','kf_subcategoryController@massdelete');

Route::post('/update/zone','zoneController@update');
Route::post('/add/zone','zoneController@add');
Route::post('/delete/zone','zoneController@delete');
Route::post('/massdelete/zone','zoneController@massdelete');

Route::post('/update/localite','localiteController@update');
Route::post('/add/localite','localiteController@add');
Route::post('/delete/localite','localiteController@delete');
Route::post('/massdelete/localite','localiteController@massdelete');

Route::post('/delete/header','headerController@delete');
Route::post('/massdelete/header','headerController@massdelete');

Route::post('/database/guide_import','localDataController@guide_import');
Route::post('/accessimport','localDataController@verifyaccessimport');
Route::post('/accessmanage','localDataController@verifyaccessmanage');