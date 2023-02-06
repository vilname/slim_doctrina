<?php

declare(strict_types=1);

$builder = new \DI\ContainerBuilder();

$builder->addDefinitions(require __DIR__ . '/../config/dependencies.php');

return $builder->build();
