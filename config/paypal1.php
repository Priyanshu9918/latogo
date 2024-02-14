<?php
return [
    'sandbox'   => true,

    'business'  => 'hallo@latogo.de',

    'paypal_lib_currency_code'  => 'USD',

    'paypal_lib_button_path'    => 'assets/images/',

    'paypal_lib_ipn_log'        => false,

    'paypal_lib_ipn_log_file'   => storage_path('/').'logs/paypal_ipn.log',

    "PAYPAL_ENVIRONMENT" => env('PAYPAL_ENVIRONMENT')!=NULL ? env('PAYPAL_ENVIRONMENT') : "sandbox",

    "PAYPAL_ENDPOINTS" => array(
        "sandbox" => "https://api.sandbox.paypal.com",
        "production" => "https://api-m.paypal.com"
    ),

    "PAYPAL_CREDENTIALS" => array(
        "sandbox" => [
            "client_id" => env('PAYPAL_CLIENT_ID'),
            "client_secret" => env('PAYPAL_SECRET')
        ],
        "production" => [
            "client_id" => env('PAYPAL_CLIENT_ID'),
            "client_secret" => env('PAYPAL_SECRET')
        ]
    ),

    "PAYPAL_REST_VERSION" => "v2",

    "SBN_CODE" => "PP-DemoPortal-EC-Psdk-ORDv2-php"
];