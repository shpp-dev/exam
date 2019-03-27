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
    Route::get('exam/status', 'ExamSessionController@gstatus')->name('status');
});

Route::group(['middleware' => ['ptp.auth', 'ptp.access']], function () {
    Route::post('exam/start', 'ExamSessionController@start')->name('start');
});

Route::group(['middleware' => ['ptp.auth', 'ptp.current']], function () {
    Route::get('exam/programming/task', 'ProgrammingController@getTask')->name('task');
    Route::post('exam/programming/answer', 'ProgrammingController@saveAnswer')->name('answer');
    Route::post('exam/type/speed', 'TypeSpeedController@saveResult')->name('typeSpeed');
    Route::post('exam/finish', 'ExamSessionController@finish')->name('finish');
});

Route::group(['middleware' => ['ptp.auth', 'ptp.admin']], function() {
    Route::get('list/unchecked', 'AdminController@listUnchecked');
    Route::get('list/checked', 'AdminController@listChecked');
    Route::post('check', 'AdminController@check');
});
