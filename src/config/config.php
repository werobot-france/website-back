<?php
return [
    'app_name' => envOrDefault('APP_NAME', ''),
    'app_env' => envOrDefault('APP_ENV', ''),
    'debug' => getEnvBoolean('DEBUG'),
    'recaptcha' => [
        'private' => getenv('RECAPTCHA_PRIVATE')
    ],
    'image_upload' => [
        'destination_path' => getenv('IMAGE_PATH'),
        'public_base_path' => getenv('IMAGE_PUBLIC_BASE_URL')
    ],
    'contact_message_discord_webhook' => getenv('CONTACT_MESSAGE_DISCORD_WEBHOOK'),
    'root_path' => dirname(dirname(__DIR__)) . '/tmp',
    'bypass_instagram_scraping' => getEnvBoolean('BYPASS_INSTAGRAM_SCRAPING'),
    'cors_allowed_origins' => getAllowedOrigins([
        'https://werobot.fr',
        'https://www.werobot.fr',
        'https://admin.werobot.fr',
        'https://web.werobot.fr',
        'https://api.werobot.fr',
        'http://localhost:3000'
    ])
];
