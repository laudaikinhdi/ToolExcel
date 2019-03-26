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

Route::get('/','ExcelController@index');
Route::post('/','ExcelController@excelJson');
Route::get('/translate','ExcelController@getTranslate');
Route::post('/translate','ExcelController@postTranslate');
Route::get('/vue', function(){
    return view('vue.index');
});