<?php

declare(strict_types=1);

namespace App\Modules\Auth\Query\FindIdentityById;

class Identity
{
    public function __construct(
        public string $id,
        public string $role
    ) {
    }
}
