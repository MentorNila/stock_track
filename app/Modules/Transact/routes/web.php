<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Transact', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Transact\Controllers'], function() {
    Route::GET('/log_transact', 'TransactsController@index')->name('logTransacts.index');
    Route::GET('/pending_transact', 'TransactsController@pending_transact')->name('pendingTransacts.index');
    
    Route::GET('/transacts/edit/{transactId}', 'TransactsController@edit')->name('transacts.edit');
    Route::GET('/transacts/delete/{transactId}', 'TransactsController@delete')->name('transacts.delete');

    Route::post('/transacts/update/{transactId}', [
        'as' => 'transacts.update',
        'uses' => 'TransactsController@update'
    ]);
    Route::post('/transacts/store', [
        'as' => 'transacts.store',
        'uses' => 'TransactsController@store'
    ]);
});
