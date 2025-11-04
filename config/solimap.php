<?php

return [
    'app' => [
        'prefix' => env('SOLIMAP_APP_PREFIX', 'solimap'),
    ],
    'base_url'  => env('SOLIMAP_BASE_URL', 'https://pay2go.solimap.com/api/v1'),
    'client_id' => env('SOLIMAP_CLIENT_ID'),
    'event_id'  => env('SOLIMAP_EVENT_ID'),
];
