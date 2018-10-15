<?php
return [
    'staileu' => [
        'public' => getenv('STAILEU_PUBLIC'),
        'private' => getenv('STAILEU_PRIVATE'),
        'redirect' => getenv('STAILEU_REDIRECT')
    ],
    'default_admin_user_id' => getenv('DEFAULT_ADMIN_USER_ID'),
    'jwt' => [
        'key' => getenv('JWT_KEY')
    ],
    'master_api_key' => getenv('MASTER_API_KEY')
];