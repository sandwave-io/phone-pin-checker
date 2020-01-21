<?php

use Illuminate\Support\Facades\Route;

Route::post('phone-pin-checker', '\Sandwave\Http\Controllers\PhonePinCheckerController@create')->name('phone-pin-checker.create');

Route::get('phone-pin-checker', '\Sandwave\Http\Controllers\PhonePinCheckerController@check')->name('phone-pin-checker.check');
