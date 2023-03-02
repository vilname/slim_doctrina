<?php

declare(strict_types=1);

namespace App\Modules\Auth\Query\FindIdByCredentials;

class Query
{
    public string $email = '';
    public string $password = '';
}
