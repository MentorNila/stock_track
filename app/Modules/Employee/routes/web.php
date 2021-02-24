<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Employee', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Employee\Controllers'], function() {
    Route::GET('/employees', 'EmployeesController@index')->name('employees.index');
    Route::GET('/employees/org', 'EmployeesController@org')->name('employees.org');
    Route::GET('/employees/create', 'EmployeesController@create')->name('employees.create');
    Route::GET('/employees/{userId}/edit', 'EmployeesController@edit')->name('employees.edit');
    Route::post('/employees/{userId}/update', 'EmployeesController@update')->name('employees.update');
    Route::GET('/employees/set/{employeeId}', 'EmployeesController@set')->name('employees.set');

    Route::post('/employees/store', [
        'as' => 'employees.store',
        'uses' => 'EmployeesController@store'
    ]);
});
