<?php

declare(strict_types=1);

namespace App\Modules\Auth\Query\FindIdentityById;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Result;

class Fetcher
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @throws Exception
     */
    public function fetch(string $id): ?Identity
    {
        $result = $this->connection->createQueryBuilder()
            ->select(['id', 'role'])
            ->from('auth_users')
            ->where('id = :id')
            ->setParameter(':id', $id)
            ->executeQuery();

        $row = $result->fetchAssociative();

        if ($row === false) {
            return null;
        }

        return new Identity(
            id: $row['id'],
            role: $row['role']
        );
    }
}
