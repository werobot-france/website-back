<?php

use Psr\Container\ContainerInterface;

return [
    'settings.displayErrorDetails' => function (ContainerInterface $container) {
        return $container->get('debug');
    },
    'settings.debug' => function (ContainerInterface $container) {
        return $container->get('debug');
    },
    \Illuminate\Database\Capsule\Manager::class => function (ContainerInterface $container) {
        $capsule = new \Illuminate\Database\Capsule\Manager;
        $capsule->addConnection($container->get('db'));

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        return $capsule;
    },
    STAILEUAccounts\STAILEUAccounts::class => function (ContainerInterface $container) {
        return new STAILEUAccounts\STAILEUAccounts(
            $container->get('staileu')['private'],
            $container->get('staileu')['public']
        );
    },
    \App\ReCaptcha::class => function (ContainerInterface $container) {
        return new \App\ReCaptcha($container->get('recaptcha')['private']);
    },
    \App\Instagram::class => function (ContainerInterface $container) {
        return new \App\Instagram($container->get('instagram')['access_token']);
    },
    \Lefuturiste\LocalStorage\LocalStorage::class => function () {
        return new \Lefuturiste\LocalStorage\LocalStorage(dirname(dirname(__DIR__)) . '/tmp/local_storage.json');
    },
    \DiscordWebhooks\Client::class => function (ContainerInterface $container) {
        return new \DiscordWebhooks\Client($container->get('contact_message_discord_webhook'));
    }
];
