<?php

declare(strict_types=1);

namespace App\Modules\Auth\Query\FindIdByCredentials;

class User
{
    public function __construct(
        public string $id,
        public bool $isActive,
    ) {
    }
}
