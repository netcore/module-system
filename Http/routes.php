<?php

Route::group([
    'middleware' => ['web', 'auth.admin'],
    'prefix'     => 'admin',
    'as'         => 'admin::',
    'namespace'  => 'Modules\System\Http\Controllers'
], function () {

    Route::get('system/phpinfo', [
        'as'   => 'system.phpinfo',
        'uses' => 'SystemController@phpInfo'
    ]);

    Route::get('system/pagination', [
        'as'   => 'system.pagination',
        'uses' => 'SystemController@pagination'
    ]);

    Route::get('system/view-data/{id}', [
        'as'   => 'system.view-data',
        'uses' => 'SystemController@viewData'
    ]);

    Route::resource('system', 'SystemController')->only(['index', 'destroy']);
});
