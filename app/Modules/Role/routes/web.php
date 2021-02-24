<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'User', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Role\Controllers'], function() {

    Route::get('roles/get-role', [
        'as' => 'roles.get-role',
        'uses' => 'RolesController@getRole'
    ]);

    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController', [
        'except' => ['create', 'edit']
    ]);
    Route::post('role/permissions', 'RolesController@rolesPermissions')->name('role.permissions');

    Route::post('roles/store', 'RolesController@store')->name('roles.store');
    Route::put('roles/update', 'RolesController@update')->name('roles.update');
});
