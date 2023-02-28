<?php

declare(strict_types=1);

use Finesse\SwiftMailerDefaultsPlugin\SwiftMailerDefaultsPlugin;
use Psr\Container\ContainerInterface;

return [
    Swift_Mailer::class => static function (ContainerInterface $container) {
        $config = $container->get('config')['mailer'];

        $transport = (new Swift_SmtpTransport($config['host'], $config['port']))
            ->setUsername($config['user'])
            ->setPassword($config['password'])
            ->setEncryption($config['encryption']);

        $mailer = new Swift_Mailer($transport);

        $mailer->registerPlugin(new SwiftMailerDefaultsPlugin([
            'from' => $config['from'],
        ]));

        return $mailer;
    },

    'config' => [
        'mailer' => [
            'host' => getenv('MAILER_HOST'),
            'port' => getenv('MAILER_PORT'),
            'user' => getenv('MAILER_USER'),
            'password' => getenv('MAILER_PASSWORD'),
            'encryption' => getenv('MAILER_ENCRYPTION'),
            'from' => [(string)getenv('MAILER_FROM_EMAIL') => 'Auction'],
        ],
    ],
];
