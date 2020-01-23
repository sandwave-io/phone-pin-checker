<?php

return [

    // Codes will stay valid for this long after creating (seconds)
    'expire' => env('PHONE_PIN_CHECKER_EXPIRE_SECONDS', 3600),

    // Optional middlware for create call
    'middleware' => [],

    // Save optional data from request on create
    'optional_data' => []

];
