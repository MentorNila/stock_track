<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Transact', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Transact\Controllers'], function() {
    Route::GET('/log_transact', 'TransactsController@index')->name('logTransacts.index');
    Route::GET('/pending_transact', 'TransactsController@pending_transact')->name('pendingTransacts.index');
});
