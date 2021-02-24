<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Goal', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Goal\Controllers'], function() {
    Route::GET('/goals', 'GoalsController@index')->name('goals.index');
    Route::GET('/goals/company', 'GoalsController@company')->name('goals.company');
    Route::GET('/goals/create', 'GoalsController@create')->name('goals.create');
    Route::GET('/goals/employee_goals/{employeeId}', 'GoalsController@employee_goals')->name('goals.employee_goals');
    Route::GET('/goals/delete/{goalId}', 'GoalsController@delete')->name('goals.delete');

    Route::post('/goals/store', [
        'as' => 'goals.store',
        'uses' => 'GoalsController@store'
    ]);

    Route::GET('/goals/categories', 'GoalsController@categories')->name('goals.categories');
    Route::GET('/goals/categories/delete/{categoryId}', 'GoalsController@delete_category')->name('categories.delete');

    Route::post('/goals/categories/store', [
        'as' => 'goal_categories.store',
        'uses' => 'GoalsController@store_category'
    ]);
});
