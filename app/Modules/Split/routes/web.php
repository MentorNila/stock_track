<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Split', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Split\Controllers'], function() {
    Route::GET('/splits', 'SplitsController@index')->name('splits.index');
    Route::GET('/splits/create', 'SplitsController@create')->name('splits.create');

    Route::delete('/splits/delete/{splitId}', 'SplitsController@delete')->name('splits.delete');
    Route::GET('/splits/edit/{splitId}', 'SplitsController@edit')->name('splits.edit');
    Route::post('/splits/update/{splitId}', 'SplitsController@update')->name('splits.update');

    Route::post('/splits/store', [
        'as' => 'splits.store',
        'uses' => 'SplitsController@store'
    ]);
});
