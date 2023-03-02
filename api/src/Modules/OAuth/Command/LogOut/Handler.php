<?php

declare(strict_types=1);

namespace App\Modules\OAuth\Command\LogOut;

use App\Modules\OAuth\Entity\AuthCodeRepository;
use App\Modules\OAuth\Entity\RefreshTokenRepository;

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
        $this->authCodes->removeAllForUser($command->userId);
        $this->refreshTokens->removeAllForUser($command->userId);
    }
}
