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

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

Auth::routes();

Route::get('/', 'HomeController@index')->name('dashboard');

Route::get('/view/{id}', 'NodeController@view')->name('node.view');
Route::get('/monitor/{id}', 'NodeController@monitor')->name('node.monitor');
Route::post('/node/post', 'NodeController@post')->name('node.post');
Route::post('/node/{id}/update', 'NodeController@update')->name('node.update');
Route::post('/node/{id}/clear', 'NodeController@clear')->name('node.clear');
Route::post('/node/{id}/delete', 'NodeController@delete')->name('node.delete');
Route::get('/write', 'NodeController@write')->name('node.write');

Route::post('/sensor/post', 'SensorController@post')->name('sensor.post');
Route::post('/sensor/delete', 'SensorController@delete')->name('sensor.delete');
Route::post('/sensor/{id}/update', 'SensorController@update')->name('sensor.update');
