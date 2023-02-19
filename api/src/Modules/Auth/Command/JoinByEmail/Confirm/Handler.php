<?php

declare(strict_types=1);

namespace App\Modules\Auth\Command\JoinByEmail\Confirm;

use App\Modules\Auth\Entity\User\UserRepository;
use App\Modules\Flusher;
use DateTimeImmutable;
use DomainException;

class Handler
{
    private UserRepository $users;
    private Flusher $flusher;

    public function __construct(UserRepository $users, Flusher $flusher)
    {
        $this->users = $users;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        if (!$user = $this->users->findByJoinConfirmToken($command->token)) {
            throw new DomainException('Incorrect token.');
        }

        $user->confirmJoin($command->token, new DateTimeImmutable());

        $this->flusher->flush();
    }
}
