<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_TNS', ''),
        'host'           => env('DB_HOST_SECOND', '192.168.2.23'),
        'port'           => env('DB_PORT_SECOND', '1521'),
        'database'       => env('DB_DATABASE_SECOND', 'orcl'),
        'username'       => env('DB_USERNAME_SECOND', 'aasif'),
        'password'       => env('DB_PASSWORD_SECOND', 'ahmed204'),
        'charset'        => env('DB_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_PREFIX', ''),
        'prefix_schema'  => env('DB_SCHEMA_PREFIX', ''),
       // 'edition'        => env('DB_EDITION', 'ora$base'),
        'server_version' => env('DB_SERVER_VERSION', '10g'),
    ],
];
