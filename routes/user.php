<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->namespace('User')->name('user.')->group(function () {
    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/form/build', 'FormController@create')->name('form.create');
    Route::post('/form/store', 'FormController@store')->name('form.store');
    Route::post('/form/update', 'FormController@update')->name('form.update');
    Route::post('/form/delete/', 'FormController@delete')->name('form.delete');
    Route::get('/csv/download/{id}', 'FormController@download')->name('csv.download');
});
