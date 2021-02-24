<?php

Route::group(['middleware' => ['web', 'auth']], function () {

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'module' => 'Client', 'namespace' => 'App\Modules\Client\Controllers'], function () {

        Route::get('clients/register/{id?}', 'ClientController@register')->name('clients.register');
        Route::post('clients/store', 'ClientController@postRegister')->name('client.store');

        Route::get('clients/check-subdomain', [
            'as' => 'client.check-subdomain',
            'uses' => 'ClientController@checkIfSubdomainExists'
        ]);

        Route::delete('clients/destroy', 'ClientController@massDestroy')->name('clients.massDestroy');
        Route::resource('clients', 'ClientController');

    });
});
