<?php

use App\Http\Controllers\fileUploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
Route::get('/password', function(){
    return Hash::make("eioptgjeopjgoper");
});
Auth::routes();

Route::group(['middleware' => 'auth:web'], function () {


Route::get('/file','FileUploadController@uploadFile');
Route::post('/file','FileUploadController@fileUploaded')->name('file.Uploaded');

});

Route::get('/attendance/{id}/{date}', 'fileController@show');
Route::get('/attendance/{id}/{d_id}/{date}', 'fileController@showDepartmentDetails');
Route::get('/search', 'fileController@search');
Route::get('/summary', 'fileController@summary');
Route::get('/sumtwo', 'fileController@sumTwo');

Route::get('/attendance', 'fileController@attendance');

Route::get('/test','fileController@test');

/* Route::get('/','FileUploadController@uploadFile'); */



Route::get('/month', 'fileController@month');

Route::get('/', function(){
    return view('pages.home');
});

Route::get('/about', function(){
    return view('pages.about');
});

Route::get('/individual','fileController@individual');






Auth::routes();


