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

Auth::routes();

Route::get('/home', 'PagesController@home')->name('home');
Route::get('/chat', 'ChatsController@index')->name('chat');

/*
| Api Routes
*/

Route::group(['prefix'=>'api', 'middleware'=>'auth'], function(){
  Route::resource('users', 'Api\UsersController')->only('index');
});
