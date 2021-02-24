<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Feedback', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Feedback\Controllers'], function() {
    Route::GET('/feedbacks', 'FeedbacksController@index')->name('feedbacks.index');
    Route::GET('/feedbacks/create', 'FeedbacksController@create')->name('feedbacks.create');

    Route::GET('/feedbacks/delete/{feedbackId}', 'FeedbacksController@delete')->name('feedbacks.delete');

    Route::post('/feedbacks/store', [
        'as' => 'feedbacks.store',
        'uses' => 'FeedbacksController@store'
    ]);
});
