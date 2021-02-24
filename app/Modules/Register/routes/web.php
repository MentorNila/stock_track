<?php

Route::group(['module' => 'Register', 'namespace' => 'App\Modules\Register\Controllers'], function () {
    Route::get('client/request', 'RegisterController@registerRequest')->name('client.request');
    Route::post('client/post-request', 'RegisterController@postRequest')->name('client.postRequest');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'module' => 'Register', 'namespace' => 'App\Modules\Register\Controllers'], function () {
        Route::get('requests', 'RegisterController@listRequests')->name('register.requests');
        Route::get('requests/{id}', 'RegisterController@showRequest')->name('register.requests.show');
        Route::get('requests/{id}/decline','RegisterController@declineRequest')->name('register.requests.decline');

    });
});
