<?php

use App\Utils\ReCaptcha;
use DiscordWebhooks\Client as DiscordClient;
use Illuminate\Database\Capsule\Manager;
use Lefuturiste\LocalStorage\LocalStorage;
use Psr\Container\ContainerInterface;

return [
    'settings.displayErrorDetails' => function (ContainerInterface $container) {
        return $container->get('debug');
    },
    'settings.debug'               => function (ContainerInterface $container) {
        return $container->get('debug');
    },
    Manager::class => function (ContainerInterface $container) {
        $capsule = new Manager;
        $capsule->addConnection($container->get('db'));

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    },
//    \STAILEUAccounts\Client::class => function (ContainerInterface $container) {
//        return new STAILEUAccounts\Client(
//            $container->get('staileu')['public'],
//            $container->get('staileu')['private']
//        );
//    },
    ReCaptcha::class => function (ContainerInterface $container) {
        return new \App\ReCaptcha($container->get('recaptcha')['private']);
    },
    LocalStorage::class => function () {
        return new LocalStorage(dirname(dirname(__DIR__)) . '/tmp/local_storage.json');
    },
    DiscordClient::class => function (ContainerInterface $container) {
        return new DiscordClient($container->get('contact_message_discord_webhook'));
    },
//    \Google\Auth\OAuth2::class => function (ContainerInterface $container) {
//        return new \Google\Auth\OAuth2([
//            'clientId' => $container->get('google')['client_id'],
//            'clientSecret' => $container->get('google')['client_secret'],
//            'authorizationUri' => 'https://accounts.google.com/o/oauth2/v2/auth',
//            'redirectUri' => $container->get('google')['redirection_url'],
//            'tokenCredentialUri' => 'https://www.googleapis.com/oauth2/v4/token',
//            'scope' => $container->get('google')['scope'],
//        ]);
//    }
];
