<?php

declare(strict_types=1);

namespace App\Modules\Auth\Query\FindIdByCredentials;


use App\Modules\Auth\Entity\User\Status;
use App\Modules\Auth\Service\PasswordHasher;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Result;

class Fetcher
{
    private Connection $connection;
    private PasswordHasher $hasher;

    public function __construct(Connection $connection, PasswordHasher $hasher)
    {
        $this->connection = $connection;
        $this->hasher = $hasher;
    }

    /**
     * @throws Exception
     */
    public function fetch(Query $query): ?User
    {
        $result = $this->connection->createQueryBuilder()
            ->select([
                'id',
                'status',
                'password_hash',
            ])
            ->from('auth_users')
            ->where('email = :email')
            ->setParameter('email', mb_strtolower($query->email))
            ->executeQuery();

        $row = $result->fetchAssociative();

        if ($row === false) {
            return null;
        }

        $hash = $row['password_hash'];

        if ($hash === null) {
            return null;
        }

        if (!$this->hasher->validate($query->password, $hash)) {
            return null;
        }

        return new User(
            id: $row['id'],
            isActive: $row['status'] === Status::ACTIVE
        );
    }
}
