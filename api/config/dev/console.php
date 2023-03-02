<?php

declare(strict_types=1);

use App\Console\FixturesLoadCommand;
use Doctrine\Migrations;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\SchemaTool;
use Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Psr\Container\ContainerInterface;

return [
    DropCommand::class => static fn (ContainerInterface $container): DropCommand => new DropCommand($container->get(EntityManagerProvider::class)),
    FixturesLoadCommand::class => static function (ContainerInterface $container) {
        $config = $container->get('config')['console'];

        return new FixturesLoadCommand(
            $container->get(EntityManagerInterface::class),
            $config['fixture_paths'],
        );
    },

    'config' => [
        'console' => [
            'commands' => [
                SchemaTool\DropCommand::class,
                FixturesLoadCommand::class,

                Migrations\Tools\Console\Command\DiffCommand::class,
                Migrations\Tools\Console\Command\GenerateCommand::class,
            ],
            'fixture_paths' => [
                __DIR__ . '/../../src/Modules/Auth/Fixture',
                __DIR__ . '/../../src/Modules/Subscriber/Fixture',
            ],
        ],
    ],
];
