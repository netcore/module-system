<?php

Route::group([
    'middleware' => ['web', 'auth.admin'],
    'prefix'     => 'admin',
    'namespace'  => 'Modules\System\Http\Controllers'
], function () {
    Route::get('system/phpinfo', [
        'as'   => 'admin::system.phpinfo',
        'uses' => 'SystemController@phpInfo'
    ]);

    Route::resource('system', 'SystemController')->only(['index']);
});
