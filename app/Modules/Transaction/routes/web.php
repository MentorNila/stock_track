<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Transaction', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Transaction\Controllers'], function() {
    Route::GET('/transactions', 'TransactionsController@index')->name('transactions.index');
    Route::GET('/transactions/create', 'TransactionsController@create')->name('transactions.create');

    Route::GET('/transactions/delete/{shareholderId}', 'TransactionsController@delete')->name('transactions.delete');

    Route::post('/transactions/store', [
        'as' => 'transactions.store',
        'uses' => 'TransactionsController@store'
    ]);
});
