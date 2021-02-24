<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Split', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Split\Controllers'], function() {
    Route::GET('/splits', 'SplitsController@index')->name('splits.index');
});
