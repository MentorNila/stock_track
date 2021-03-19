<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'Reservation', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\Reservation\Controllers'], function() {
    Route::GET('/reservations', 'ReservationsController@index')->name('reservations.index');
    Route::GET('/reservations/create', 'ReservationsController@create')->name('reservations.create');

    Route::delete('/reservations/delete/{reservationId}', 'ReservationsController@delete')->name('reservations.delete');
    Route::GET('/reservations/edit/{reservationId}', 'ReservationsController@edit')->name('reservations.edit');
    Route::post('/reservations/update/{reservationId}', 'ReservationsController@update')->name('reservations.update');

    Route::post('/reservations/store', [
        'as' => 'reservations.store',
        'uses' => 'ReservationsController@store'
    ]);
});
