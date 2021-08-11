<?php

return [
    'type' => strtolower(env('KP_ZENZIVA_TYPE', 'console')), // gsm or console

    'userkey' => env('KP_ZENZIVA_USERKEY'),

    'passkey' => env('KP_ZENZIVA_PASSKEY'),
];
