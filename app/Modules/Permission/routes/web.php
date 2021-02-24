<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'User', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Permission\Controllers'], function() {

    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');
    Route::post('permissions/store', 'PermissionsController@store') -> name('permissions.store');
    Route::put('permissions/update', 'PermissionsController@update') -> name('permissions.update');
});
