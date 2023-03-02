<?php

declare(strict_types=1);

namespace App\Http\Middleware\Auth;

class Identity
{
    public function __construct(
        public string $id
    ) {
    }
}
