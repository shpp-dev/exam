<?php

use Illuminate\Http\Request;

Route::get('auth', function() {})->middleware('ptp.auth');
Route::get('location', function() {})->middleware('ptp.location');
Route::get('progress', function() {})->middleware('ptp.current');
Route::get('ecosystem', function() {})->middleware('ptp.eco');
