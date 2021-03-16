<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Certificate', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Certificate\Controllers'], function() {
    Route::GET('/certificates', 'CertificatesController@index')->name('certificates.index');
    Route::GET('/certificates/create', 'CertificatesController@create')->name('certificates.create');

    Route::GET('/certificates/delete/{certificateId}', 'CertificatesController@delete')->name('certificates.delete');
    Route::GET('/certificates/edit/{certificateId}', 'CertificatesController@edit')->name('certificates.edit');
    Route::Get('/certificates/show/{certificateId}', 'CertificatesController@show')->name('certificates.show');
    Route::POST('/certificates/update/{certificateId}', 'CertificatesController@update')->name('certificates.update');

    Route::post('/certificates/store', [
        'as' => 'certificates.store',
        'uses' => 'CertificatesController@store'
    ]);
});
