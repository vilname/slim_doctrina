<?php

declare(strict_types=1);

use Doctrine\Migrations\Configuration\Configuration;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\ExistingConfiguration;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Metadata\Storage\TableMetadataStorageConfiguration;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Doctrine\Migrations\Tools\Console\Command;

return [
    DependencyFactory::class => static function(ContainerInterface $container) {
        $entityManager = $container->get(EntityManagerInterface::class);

        $configuration = new Configuration();
        $configuration->addMigrationsDirectory('App\Data\Migration', __DIR__ . '/../../src/Data/Migration');
        $configuration->setAllOrNothing(true);
        $configuration->setCheckDatabasePlatform(false);

        $storageConfiguration = new TableMetadataStorageConfiguration();
        $storageConfiguration->setTableName('migrations');

        $configuration->setMetadataStorageConfiguration($storageConfiguration);

        return DependencyFactory::fromEntityManager(
            new ExistingConfiguration($configuration),
            new ExistingEntityManager($entityManager)
        );
    },
    Command\MigrateCommand::class => static function(ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\MigrateCommand($factory);
    },
    Command\DiffCommand::class => static function(ContainerInterface $container) {
        $factory = $container->get(DependencyFactory::class);
        return new Command\DiffCommand($factory);
    }
];
