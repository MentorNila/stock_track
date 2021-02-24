<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Certificate', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Certificate\Controllers'], function() {
    Route::GET('/certificates', 'CertificatesController@index')->name('certificates.index');
    Route::GET('/certificates/create', 'CertificatesController@create')->name('certificates.create');

    Route::GET('/certificates/delete/{shareholderId}', 'CertificatesController@delete')->name('certificates.delete');

    Route::post('/certificates/store', [
        'as' => 'certificates.store',
        'uses' => 'CertificatesController@store'
    ]);
});
