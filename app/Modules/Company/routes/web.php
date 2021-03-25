<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'module' => 'Company', 'namespace' => 'App\Modules\Company\Controllers'], function () {
        Route::delete('companies/destroy', 'CompanyController@massDestroy')->name('companies.massDestroy');
        Route::delete('companies/unactive/{companyId}', 'CompanyController@unactive')->name('companies.unactive');
        Route::resource('companies', 'CompanyController');
    	Route::GET('/companies/set/{companyId}', 'CompanyController@set')->name('companies.set');
        Route::GET('/companies/active/{companyId}', 'CompanyController@active')->name('companies.active');
        Route::POST('/companies/excel_import', 'CompanyController@excel_import')->name('companies.excel_import');

    });
});
