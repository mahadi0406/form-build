<?php

use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/user.php';
Route::get('/', 'FrontendController@index')->name('home');
Route::post('/form/submit/{id}', 'FrontendController@store')->name('form.submit');
Route::get('/{hash}', 'FrontendController@link')->name('link');
