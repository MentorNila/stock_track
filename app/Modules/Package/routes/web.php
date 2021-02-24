<?php

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'module' => 'Plans', 'namespace' => 'App\Modules\Plans\Controllers'], function () {

        Route::put('plans/update-forms{plan}', [
            'as' => 'plans.update-forms',
            'uses' => 'PlansController@updatePlanForms'
        ]);

        Route::get('plans/check-title', [
            'as' => 'plans.check-title',
            'uses' => 'PlansController@checkTitle'
        ]);


        Route::delete('plans/destroy', 'PlansController@massDestroy')->name('plans.massDestroy');
        Route::resource('plans', 'PlansController');

    });
});
