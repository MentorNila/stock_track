<?php

Route::get('/', 'AuthController@landingPage')->name('landingPage');
Route::redirect('/home', '/admin/companies');
Auth::routes(['register' => false]);
Route::post('user/login', 'AuthController@authenticate');
Route::get('user/logout', 'AuthController@logout');
