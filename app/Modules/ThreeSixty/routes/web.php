<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'ThreeSixty', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\ThreeSixty\Controllers'], function() {
    Route::GET('/three_sixty', 'ThreeSixtyController@index')->name('three_sixty.index');
    Route::GET('/three_sixty/create', 'ThreeSixtyController@create')->name('three_sixty.create');

    Route::GET('/three_sixty/delete/{feedbackId}', 'ThreeSixtyController@delete')->name('three_sixty.delete');

    Route::post('/three_sixty/store', [
        'as' => 'three_sixty.store',
        'uses' => 'ThreeSixtyController@store'
    ]);
});
