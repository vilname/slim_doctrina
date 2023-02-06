<?php

declare(strict_types=1);

//\Psr\Http\Message\ResponseFactoryInterface::class => DI\get(\Slim\Psr7\Factory\ResponseFactory::class)
return [
    'config' => [
        'debug' => (bool)getenv('APP_DEBUG')
    ]
];
