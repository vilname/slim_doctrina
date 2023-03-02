<?php

declare(strict_types=1);

namespace App\Modules\OAuth\Command\ClearExpiredItems;

use App\Modules\OAuth\Entity\AuthCodeRepository;
use App\Modules\OAuth\Entity\RefreshTokenRepository;
use DateTimeImmutable;

class Handler
{
    private AuthCodeRepository $authCodes;
    private RefreshTokenRepository $refreshTokens;

    public function __construct(AuthCodeRepository $authCodes, RefreshTokenRepository $refreshTokens)
    {
        $this->authCodes = $authCodes;
        $this->refreshTokens = $refreshTokens;
    }

    public function handle(Command $command): void
    {
        $date = new DateTimeImmutable($command->date);

        $this->authCodes->removeAllExpired($date);
        $this->refreshTokens->removeAllExpired($date);
    }
}
