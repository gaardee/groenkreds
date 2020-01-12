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

Auth::routes();

Route::get('/', 'HomeController@kortet');
Route::get('/kortet', 'HomeController@kortet')->name('kortet');
Route::get('/kortet/{kreds}', 'HomeController@kreds')->name('kortet.kreds');
Route::get('/kreds/{key}', 'KredsController@edit')->name('kreds.edit');
Route::put('/kreds/{key}', 'KredsController@update')->name('kreds.update');
Route::get('/aktiviteter/{aktivitet?}', 'HomeController@aktiviteter')->name('aktiviteter');
Route::get('/om', 'HomeController@om')->name('om');
Route::get('/bliv', 'HomeController@bliv')->name('bliv');
