<?php

Route::group([
    'middleware' => ['web', 'auth.admin'],
    'prefix'     => 'admin',
    'namespace'  => 'Modules\Setting\Http\Controllers'
], function () {
    Route::get('settings', ['as' => 'admin::setting.index', 'uses' => 'SettingController@index']);
    Route::get('settings/{setting}/edit', ['as' => 'admin::setting.edit', 'uses' => 'SettingController@edit']);
    Route::patch('settings/{setting}/{language?}', ['as' => 'admin::setting.update', 'uses' => 'SettingController@update']);
});
