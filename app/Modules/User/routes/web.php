<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'User', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\User\Controllers'], function() {

    Route::delete('user/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    Route::post('users/resend-email', [
        'as' => 'users.resend-email',
        'uses' => 'UsersController@resendEmail'
    ]);

    Route::put('users/update-password/{user}', [
        'as' => 'users.update-password',
        'uses' => 'UsersController@updatePassword'
    ]);

    Route::post('users/check-email', [
        'as' => 'users.check-email',
        'uses' => 'UsersController@checkEmail'
    ]);
});
