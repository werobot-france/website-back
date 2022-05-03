<?php
return [
    'app_name' => envOrDefault('APP_NAME', ''),
    'app_env' => envOrDefault('APP_ENV', ''),
    'debug' => getEnvBoolean('DEBUG'),
    'recaptcha' => [
        'private' => $_ENV['RECAPTCHA_PRIVATE']
    ],
    'image_upload' => [
        'destination_path' => $_ENV['IMAGE_PATH'],
        'public_base_path' => $_ENV['IMAGE_PUBLIC_BASE_URL']
    ],
    'contact_message_discord_webhook' => $_ENV['CONTACT_MESSAGE_DISCORD_WEBHOOK'],
    'root_path' => dirname(dirname(__DIR__)),
    'bypass_instagram_scraping' => getEnvBoolean('BYPASS_INSTAGRAM_SCRAPING'),
    'frontend_base_url' => envOrDefault('FRONTENV_BASE_URL', 'https://werobot.fr'),
    'cors_allowed_origins' => getAllowedOrigins([
        'https://werobot.fr',
        'https://www.werobot.fr',
        'https://admin.werobot.fr',
        'https://web.werobot.fr',
        'https://api.werobot.fr',
        'http://localhost:3000'
    ])
];
