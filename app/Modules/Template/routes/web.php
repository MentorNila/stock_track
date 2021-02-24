<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Template', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Template\Controllers'], function() {
    Route::GET('/templates', 'TemplatesController@index')->name('templates.index');
    Route::GET('/templates/create', 'TemplatesController@create')->name('templates.create');
    Route::GET('/templates/delete/{templateId}', 'TemplatesController@delete')->name('templates.delete');

    Route::post('/templates/store', [
        'as' => 'templates.store',
        'uses' => 'TemplatesController@store'
    ]);
});
