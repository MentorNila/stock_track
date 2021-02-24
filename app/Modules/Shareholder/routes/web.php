<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Shareholder', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Shareholder\Controllers'], function() {
    Route::GET('/shareholders', 'ShareholdersController@index')->name('shareholders.index');
    Route::GET('/shareholders/create', 'ShareholdersController@create')->name('shareholders.create');

    Route::delete('/shareholders/unactive/{shareholderId}', 'ShareholdersController@unactive')->name('shareholders.unactive');

    Route::post('/shareholders/store', [
        'as' => 'shareholders.store',
        'uses' => 'ShareholdersController@store'
    ]);
});
