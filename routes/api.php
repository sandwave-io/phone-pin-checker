<?php

use Illuminate\Support\Facades\Route;

Route::post('phone-pin-checker', 'Sandwave\PhonePinChecker\Http\Controllers\PhonePinCheckerController@create')
    ->name('phone-pin-checker.create')
    ->middleware(config('phone-pin-checker.middleware'));

Route::get('phone-pin-checker', 'Sandwave\PhonePinChecker\Http\Controllers\PhonePinCheckerController@check')
    ->name('phone-pin-checker.check')
    ->middleware('throttle:60,1');
