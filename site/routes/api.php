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
    Route::get('exam/status', 'ExamController@getStatus')->name('status');
});

Route::group(['middleware' => ['ptp.auth', 'ptp.access']], function () {
    Route::post('exam/start', 'ExamController@startSession')->name('start');
});

Route::group(['middleware' => ['ptp.auth', 'ptp.current']], function () {
    Route::get('exam/task', 'ExamController@getTask')->name('task');
    Route::post('exam/answer', 'ExamController@saveAnswer')->name('answer');
    Route::post('exam/finish', 'ExamController@finishExam')->name('finish');
});
