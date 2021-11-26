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

Route::get('/excel/export/job/{job}','ExcelController@exportJob')->name('excel.export.job');
Route::get('/word/export/job/{job}','WordController@exportJob')->name('word.export.job');
Route::get('/pdf/export/job/{job}','PdfController@exportJob')->name('pdf.export.job');
Route::get('/word/export/resume/{resume}','WordController@exportResume')->name('word.export.resume');
Route::get('/pdf/export/resume/{resume}','PdfController@exportResume')->name('pdf.export.resume');
Route::get('/excel/export/user/job/{user}','ExcelController@exportUserJob')->name('excel.export.user.job');
Route::get('/word/export/user/resume/{user}','WordController@exportUserResume')->name('word.export.user.resume');
Route::get('/img/export/resume/{resume}','ImgController@exportResume')->name('img.export.resume');

Route::get('/', 'SessionsController@index')->name('index');
Route::get('login', 'SessionsController@create')->name('login'); //登录页面
Route::post('login', 'SessionsController@store')->name('login'); //登录请求
Route::delete('logout', 'SessionsController@destroy')->name('logout'); //退出请求

Route::get('home', 'GeneralsController@show')->name('home');

Route::resource('users', 'UsersController'); //账户相关

Route::post('/resumes/{resume}/status', 'ResumesController@status')->name('resumes.status');
Route::post('/resumes/{resume}/addToJob', 'ResumesController@addToJob')->name('resumes.add.job');
Route::get('/resumes/create/manual', 'ResumesController@manual')->name('resumes.create.manual');
Route::post('/resumes/create/auto', 'ResumesController@auto')->name('resumes.create.auto');
Route::post('/resumes/create/batch', 'ResumesController@batch')->name('resumes.create.batch');

Route::post('/resumes/{resume}/operation', 'ResumesController@operation')->name('resumes.operation');
Route::get('/resumes/list', 'ResumesController@list')->name('resumes.list');
Route::get('/resumes/mine', 'ResumesController@mine')->name('resumes.mine');
Route::get('/resumes/current', 'ResumesController@current')->name('resumes.current');
Route::resource('resumes', 'ResumesController'); //简历相关

Route::get('/jobs/list', 'JobsController@list')->name('jobs.list'); //职位列表
Route::post('/jobs/{job}/status', 'JobsController@status')->name('jobs.status');
Route::resource('jobs', 'JobsController'); //职位相关

Route::get('/drafts/list', 'DraftsController@list')->name('drafts.list');
Route::resource('drafts', 'DraftsController');

Route::get('/companys/list', 'CompanysController@list')->name('companys.list');
Route::resource('companys', 'CompanysController');

Route::middleware(['can:rpo-manager'])->group(function () {
    Route::get('/management/job/list', 'ManagementController@jobList')->name('management.job.list');
    Route::get('/management/staff/list', 'ManagementController@staffList')->name('management.staff.list');
});

Route::middleware(['can:statistics'])->group(function () {
    Route::get('/statistics/list', 'StatisticsController@list')->name('statistics.list');
});
