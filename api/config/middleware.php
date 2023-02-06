<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;

return static function(\Slim\App $app, ContainerInterface $container): void {
    $app->addErrorMiddleware($container->get('config')['debug'], true, true);
};
