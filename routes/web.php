<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->route('agent');
});

Auth::routes();

//Route::group(['middleware' => 'auth'], function () {
    Route::resource('agent', 'AgentController');
    Route::post('/upload-file', 'FileController@uploadFile')->name('upload-file');
    Route::get('/parse-csv', 'FileController@parse');
//    Route::get('/create-test-csv', 'FileController@createTestCsv');
//});
