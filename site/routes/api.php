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
    Route::get('exam/status', 'ExamController@getStatus');
});

Route::group(['middleware' => ['ptp.auth', 'ptp.access']], function () {
    Route::post('exam/start', 'ExamController@startSession');
});

Route::group(['middleware' => ['ptp.auth', 'ptp.current']], function () {
    Route::get('exam/task', 'ExamController@getTask');
    Route::post('exam/answer', 'ExamController@saveAnswer');
    Route::post('exam/finish', 'ExamController@finishExam');
});

Route::group(['middleware' => ['ptp.auth', 'ptp.admin']], function() {
    Route::get('list/unchecked', 'AdminController@listUnchecked');
    Route::get('list/checked', 'AdminController@listChecked');
    Route::post('check', 'AdminController@check');
});
