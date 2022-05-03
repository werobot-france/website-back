<?php
return [
    'staileu' => [
        'public' => $_ENV['STAILEU_PUBLIC'],
        'private' => $_ENV['STAILEU_PRIVATE'],
        'redirect' => $_ENV['STAILEU_REDIRECT']
    ],
    'default_admin_user_id' => $_ENV['DEFAULT_ADMIN_USER_ID'],
    'jwt' => [
        'key' => $_ENV['JWT_KEY']
    ],
    'master_api_key' => $_ENV['MASTER_API_KEY'],
    'instagram' => [
        'access_token' => $_ENV['INSTAGRAM_ACCESS_TOKEN']
    ]
];
