<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Form', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Form\Controllers'], function() {
    Route::GET('/forms', 'FormsController@index')->name('forms.index');
    Route::GET('/forms/create', 'FormsController@create')->name('forms.create');
    Route::GET('/forms/delete/{formId}', 'FormsController@delete')->name('forms.delete');

    Route::post('/forms/store', [
        'as' => 'forms.store',
        'uses' => 'FormsController@store'
    ]);
});
