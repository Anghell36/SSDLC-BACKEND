<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    */

    //'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'register'],
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'attendances', 'api/attendances', 'api/reports'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:5173'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,

];

//return [
    //'paths' => ['api/*', 'sanctum/csrf-cookie'],
    //'allowed_methods' => ['*'],
    //'allowed_origins' => ['http://localhost:5173'],
    //'allowed_origins_patterns' => [],
    //'allowed_headers' => ['*'],
    //'exposed_headers' => [],
    //'max_age' => 0,
  //  'supports_credentials' => true,
//];