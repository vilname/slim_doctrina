<?php

declare(strict_types=1);

use App\Modules\Auth\Service\Tokenizer;
use Psr\Container\ContainerInterface;

return [
    Tokenizer::class => function (ContainerInterface $container): Tokenizer {
        $config = $container->get('config')['auth'];

        return new Tokenizer(new DateInterval($config['token_ttl']));
    },

    'config' => [
        'auth' => [
            'token_ttl' => 'PT1H',
        ]
    ],
];
