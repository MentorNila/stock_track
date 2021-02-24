<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'User', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\User\Controllers'], function() {


});
