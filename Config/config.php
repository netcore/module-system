<?php

return [
    //Toggle server information in the System section
    'server-info'    => true,

    //Toggle PHP information in the System section
    'php-info'       => true,

    //Toggle log files in the System section
    'log-files'      => true,

    //Toggle what information should be logged
    'columns'        => [
        'type'     => true,
        'ip'       => true,
        'browser'  => true,
        'platform' => true
    ],

    //Add custom information to the logs. Be sure to create a migration and actually add the columns to the database
    'custom_columns' => [
        //Example
        //'api_user_id' => 'API User ID'
    ]
];
