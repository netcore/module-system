<?php

Route::group([
    'middleware' => ['web', 'auth.admin'],
    'prefix'     => 'admin',
    'namespace'  => 'Modules\System\Http\Controllers'
], function () {
    Route::resource('system', 'SystemController')->only(['index']);
});
