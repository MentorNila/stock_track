<?php

Route::group(['middleware' => ['web', 'auth'], 'module' => 'Filing', 'namespace' => 'App\Modules\Filing\Controllers'], function () {

    Route::get('filing-datas/show-filing-data/{filingId}', 'FilingDataController@showFilingData')->name('filing-datas.showFilingData');
    Route::delete('filing-datas/destroy', 'FilingDataController@massDestroy')->name('filing-datas.massDestroy');
    Route::resource('filing-datas', 'FilingDataController');



    //generate Filings
    Route::post('generate-filing/storeFiling', [
        'as' => 'generate-filing.storeFiling',
        'uses' => 'GenerateFilingsController@storeFiling'
    ]);
    Route::any('generate-filing/generateFiling/{filingId}', [
        'as' => 'generate-filing.generateFiling',
        'uses' => 'GenerateFilingsController@generateFiling'
    ]);

    Route::any('generate-filing/upload-data', [
        'as' => 'generate-filing.uploadData',
        'uses' => 'GenerateFilingsController@uploadData'
    ]);

    Route::any('generate-filing/confirmation', [
        'as' => 'generate-filing.confirmation',
        'uses' => 'GenerateFilingsController@confirmation'
    ]);

    Route::get('form-exhibits', [
        'as' => 'generate-filing.get-exhibits',
        'uses' => 'GenerateFilingsController@getExhibits'
    ]);

    Route::post('generate-filing/confirm-data', [
        'as' => 'generate-filing.store-content',
        'uses' => 'GenerateFilingsController@storeContent'
    ]);

    Route::get('generate-filing/confirm-financial-data/{filingId}', [
        'as' => 'generate-filing.confirm-data',
        'uses' => 'GenerateFilingsController@confirmFinancialStatements'
    ]);

    Route::post('generate-filing/update-financial-data/', [
        'as' => 'generate-filing.update-financial-data',
        'uses' => 'GenerateFilingsController@updateFinancialData'
    ]);

    Route::get('generate-filing/confirm-exhibits/{filingId}', [
        'as' => 'generate-filing.confirm-exhibits',
        'uses' => 'GenerateFilingsController@confirmExhibits'
    ]);

    Route::post('generate-filing/update-exhibits', [
        'as' => 'generate-filing.update-exhibits',
        'uses' => 'GenerateFilingsController@updateExhibits'
    ]);

    Route::get('generate-filing/confirm-converted-document/{filingId}', [
        'as' => 'generate-filing.confirm-converted-document',
        'uses' => 'GenerateFilingsController@confirmConvertedDocument'
    ]);

    Route::post('generate-filing/update-converted-document', [
        'as' => 'generate-filing.update-converted-document',
        'uses' => 'GenerateFilingsController@updateConvertedDocument'
    ]);

    Route::post('generate-filing/generate-filing', [
        'as' => 'generate-filing.generate-filing',
        'uses' => 'GenerateFilingsController@generateFiling'
    ]);

    Route::get('generate-filing/add-new-exhibit', [
        'as' => 'generate-filing.add-new-exhibit',
        'uses' => 'GenerateFilingsController@addNewExhibitContent'
    ]);

    Route::get('generate-filing/download-zip/{fileName}', [
        'as' => 'generate-filing.download-zip',
        'uses' => 'GenerateFilingsController@downloadZip'
    ]);


    Route::delete('generate-filing/destroy', 'GenerateFilingsController@massDestroy')->name('generate-filing.massDestroy');
    Route::resource('generate-filing', 'GenerateFilingsController');


});

