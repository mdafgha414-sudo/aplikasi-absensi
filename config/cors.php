<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    // 1. Daftarkan route scan di sini
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'absensi/proses-scan'],

    'allowed_methods' => ['*'],

    // 2. Samakan persis dengan URL di address bar HP Anda
    'allowed_origins' => ['https://aplikasi-absensi-production-0e98.up.railway.app'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];