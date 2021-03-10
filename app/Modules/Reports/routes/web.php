<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Reports', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Reports\Controllers'], function() {
    Route::GET('/reports/{reportName}', 'ReportsController@index')->name('reporting.index');
    Route::GET('/reports', 'ReportsController@index')->name('reporting.index');

});
