<?php
return [
    'app_name' => envOrDefault('APP_NAME', ''),
    'app_env' => envOrDefault('APP_ENV', ''),
    'debug' => envOrDefault('DEBUG', false) === 'true' || envOrDefault('DEBUG', false) === '1' ? true: false,

    'recaptcha' => [
        'private' => getenv('RECAPTCHA_PRIVATE')
    ],
    'image_upload' => [
        'destination_path' => getenv('IMAGE_UPLOAD_DESTINATION_PATH'),
        'public_base_path' => getenv('IMAGE_UPLOAD_PUBLIC_BASE_URL')
    ],
    'contact_message_discord_webhook' => getenv('CONTACT_MESSAGE_DISCORD_WEBHOOK')
];
