<?php

declare(strict_types=1);

namespace App\Modules\OAuth\Command\LogOut;

class Command
{
    public string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }
}
