<?php

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'module' => 'Dashboard', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Dashboard\Controllers'], function () {

    Route::GET('/dashboard', 'HomeController@index')->name('home');
});

Route::group(['module' => 'Dashboard', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Dashboard\Controllers'], function () {

    Route::GET('/dashboard', 'HomeController@userDashboard')->name('home.user');
    Route::GET('/notification', 'HomeController@notification')->name('notification');

});


Route::get('notification/mark-notification-as-read', [
    'as' => 'notification.mark-notification-as-read',
    'uses' => 'App\Modules\User\Controllers\UsersController@markNotificationAsRead',
    'middleware' => ['web', 'auth']
]);
