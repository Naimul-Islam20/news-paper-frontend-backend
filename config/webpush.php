<?php

return [
    'enabled' => filter_var(env('WEBPUSH_ENABLED', true), FILTER_VALIDATE_BOOLEAN),

    'public_key' => env('VAPID_PUBLIC_KEY'),

    'private_key' => env('VAPID_PRIVATE_KEY'),

    'subject' => env('VAPID_SUBJECT', env('APP_URL', 'mailto:admin@example.com')),
];
