<?php

return [

    // Codes will stay valid for this long after creating (seconds)
    'expire' => env('PHONE_PIN_CHECKER_EXPIRE_SECONDS', 3600),

    // Optional middleware for create call
    'middleware' => [],
];
