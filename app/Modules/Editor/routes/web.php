<?php

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::group(['prefix' => 'editor', 'module' => 'Editor', 'as' => 'editor.', 'namespace' => 'App\Modules\Editor\Controllers'], function () {

        Route::post('ckeditor/image_upload', 'EditorController@upload')->name('ckeditorUpload');

        Route::get('/{filingId}', [
            'as' => 'edit-content',
            'uses' => 'EditorController@index'
        ]);

        Route::get('data/get-tag-period', [
            'as' => 'data.get-tag-period',
            'uses' => 'EditorController@getTagPeriod'
        ]);

        Route::get('data/check-tag-type', [
            'as' => 'data.check-tag-type',
            'uses' => 'EditorController@checkTagType'
        ]);

        Route::get('data/search', [
            'as' => 'data.search',
            'uses' => 'EditorController@searchTag'
        ]);

        Route::get('data/get-tag-attributes', [
            'as' => 'data.get-tag-attributes',
            'uses' => 'EditorController@getTagAttributes'
        ]);

        Route::post('/save-as-draft', [
            'as' => 'save-as-draft',
            'uses' => 'EditorController@saveAsDraft'
        ]);

        Route::post('exhibit/save-exhibit-as-draft', [
            'as' => 'exhibit.save-exhibit-as-draft',
            'uses' => 'EditorController@saveExhibitAsDraft'
        ]);

        Route::post('tag/store-tag', [
            'as' => 'tag.store-tag',
            'uses' => 'EditorController@storeTag'
        ]);

        Route::get('tag/delete-tag', [
            'as' => 'tag.delete-tag',
            'uses' => 'EditorController@deleteTag'
        ]);

        Route::get('tag/get-tag-data', [
            'as' => 'tag.get-tag-data',
            'uses' => 'EditorController@prepareModal'
        ]);

        Route::get('data/get-user-filing', [
            'as' => 'data.get-user-filing',
            'uses' => 'EditorController@getUserFiling'
        ]);

        Route::get('review/get-comments', [
            'as' => 'data.get-comments',
            'uses' => 'EditorController@getComments'
        ]);

        Route::post('data/assign-users', [
            'as' => 'data/assign-users',
            'uses' => 'EditorController@assignUsersToFiling'
        ]);
    });
});

