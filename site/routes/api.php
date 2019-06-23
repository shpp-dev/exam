<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['ptp.auth']], function () {
    Route::get('exam/status', 'ExamSessionController@status')->name('status');
});

// todo add 'ptp.access' middleware for production
Route::group(['middleware' => ['ptp.auth']], function () {
    Route::post('exam/start', 'ExamSessionController@start')->name('start');
});

// todo add 'ptp.current' middleware for production
Route::group(['middleware' => ['ptp.auth']], function () {
    Route::get('exam/list', 'ExamSessionController@examsList')->name('examsList');

    Route::get('exam/programming/task', 'ProgrammingController@getTask')->name('programmingTask');
    Route::post('exam/programming/answer', 'ProgrammingController@saveAnswer')->name('programmingAnswer');
    Route::post('exam/programming/finish', 'ProgrammingController@finish')->name('programmingFinish');

    Route::get('exam/english/question', 'EnglishController@getQuestion')->name('englishQuestion');
    Route::post('exam/english/answer', 'EnglishController@saveAnswer')->name('englishAnswer');
    Route::post('exam/english/finish', 'EnglishController@finish')->name('englishFinish');

    Route::post('exam/type/start', 'TypeSpeedController@start')->name('typeStart');
    Route::post('exam/type/speed', 'TypeSpeedController@saveResult')->name('typeSpeed');

//    Route::post('exam/finish', 'ExamSessionController@finish')->name('finish');
});

// todo 'ptp.admin' middleware for production
Route::group(['middleware' => ['ptp.auth']], function() {
    Route::get('admin/list/{status}', 'AdminController@list');
    Route::post('admin/check', 'AdminController@check');
});

Route::group(['middleware' => ['ptp.eco']], function() {
   Route::post('user/register', 'UserController@createUser');
});
