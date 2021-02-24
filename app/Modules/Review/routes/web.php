<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Review', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Review\Controllers'], function() {
    Route::GET('/reviews', 'ReviewsController@index')->name('reviews.index');
    Route::GET('/reviews/company', 'ReviewsController@company')->name('reviews.company');
    Route::GET('/reviews/create', 'ReviewsController@create')->name('reviews.create');
    Route::GET('/reviews/view/{reviewId}', 'ReviewsController@view')->name('reviews.view');
    Route::GET('/reviews/delete/{reviewId}', 'ReviewsController@delete')->name('reviews.delete');
    Route::GET('/reviews/form/delete/{formId}', 'ReviewsController@delete_form')->name('reviews.form.delete');
    Route::GET('/reviews/form/{reviewId}', 'ReviewsController@form')->name('reviews.form.view');

    Route::post('/reviews/form/submit_form/{formId}', [
        'as' => 'reviews.form.submit_form',
        'uses' => 'ReviewsController@submit_form'
    ]);

    Route::post('/reviews/store', [
        'as' => 'reviews.store',
        'uses' => 'ReviewsController@store'
    ]);
});
