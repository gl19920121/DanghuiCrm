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

Route::get('/', 'SessionsController@index')->name('index');

Route::resource('users', 'UsersController'); //账户相关
Route::resource('resumes', 'ResumesController'); //简历相关
Route::resource('jobtasks', 'JobTasksController'); //简历相关

Route::get('login', 'SessionsController@create')->name('login'); //登录页面
Route::post('login', 'SessionsController@store')->name('login'); //登录请求
Route::delete('logout', 'SessionsController@destroy')->name('logout'); //退出请求

Route::get('home', 'GeneralsController@show')->name('home');
