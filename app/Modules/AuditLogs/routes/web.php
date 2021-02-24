<?php

Route::group(['prefix' => 'admin' , 'as' => 'admin.', 'module' => 'AuditLogs', 'middleware' => ['web', 'auth'], 'namespace' => 'App\Modules\AuditLogs\Controllers'], function() {

    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

});
