<?php

declare(strict_types=1);

namespace App\Modules\Auth\Entity\User;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use DomainException;

class UserRepository
{
    /**
     * @var EntityRepository
     */
    private EntityRepository $repo;
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     * @param EntityRepository $repo
     */
    public function __construct(EntityManagerInterface $em, EntityRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    public function hasByEmail(Email $email): bool
    {
        return $this->repo->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.email = :email')
                ->setParameter(':email', $email->getValue())
                ->getQuery()->getSingleScalarResult() > 0;
    }

    /**
     * @param string $token
     * @return User|object|null
     */
    public function findByJoinConfirmToken(string $token): ?User
    {
        return $this->repo->findOneBy(['joinConfirmToken.value' => $token]);
    }

    /**
     * @param string $token
     * @return User|object|null
     */
    public function findByPasswordResetToken(string $token): ?User
    {
        return $this->repo->findOneBy(['passwordResetToken.value' => $token]);
    }

    /**
     * @param string $token
     * @return User|object|null
     */
    public function findByNewEmailToken(string $token): ?User
    {
        return $this->repo->findOneBy(['newEmailToken.value' => $token]);
    }

    public function get(Id $id): User
    {
        /** @var User|null $user */
        $user = $this->repo->find($id->getValue());
        if ($user === null) {
            throw new DomainException('User is not found.');
        }
        return $user;
    }

    public function getByEmail(Email $email): User
    {
        /** @var User|null $user */
        $user = $this->repo->findOneBy(['email' => $email->getValue()]);
        if ($user === null) {
            throw new DomainException('User is not found.');
        }
        return $user;
    }

    public function add(User $user): void
    {
        $this->em->persist($user);
    }

    public function remove(User $user): void
    {
        $this->em->remove($user);
    }
}
