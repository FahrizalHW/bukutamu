<?php

return [
    'name' => env('OPERATOR_NAME', env('GUEST_NAME')),
    'username' => env('OPERATOR_USERNAME', env('GUEST_USERNAME')),
    'password' => env('OPERATOR_PASSWORD', env('GUEST_PASSWORD')),
];
