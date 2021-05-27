<?php

return [
    /*
    |--------------------------------------------------------------------------
    | MyCart Configuration File
    |--------------------------------------------------------------------------
    |
    | Define custom variables only if you wanna change it...
    |
    */

    // Define session name
    'session_name' => env('MYCART_SESSION_NAME', 'mycart'),

    // Define items key name
    'items_name' => env('MYCART_ITEMS_NAME', 'items'),

    // Define price field name
    'price_name' => env('MYCART_PRICE_NAME', 'price'),
];
