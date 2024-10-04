<?php

return [
    'user' => [
        'model' => env('SUPPORT_USER_MODEL', config('auth.providers.users.model')),
        'chat_key' => env('SUPPORT_USER_KEY', 'telegram_chat_id'),
    ],

    'admin' => [
        'model' => env('SUPPORT_ADMIN_MODEL', config('auth.providers.users.model')),
        'chat_key' => env('SUPPORT_ADMIN_KEY', 'telegram_chat_id'),
    ],

    'bot' => [
        'token' => env('TELEGRAM_SUPPORT_BOT_TOKEN'),
        'name' => env('TELEGRAM_SUPPORT_BOT_NAME'),
        'group_id' => env('TELEGRAM_SUPPORT_BOT_GROUP_ID'),
        'queue' => [
            'enabled' => env('TELEGRAM_SUPPORT_BOT_QUEUE_ENABLED', true),
            'name' => env('TELEGRAM_SUPPORT_BOT_QUEUE_NAME', 'default'),
        ]
    ]
];