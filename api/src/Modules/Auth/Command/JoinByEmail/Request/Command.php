<?php

declare(strict_types=1);

namespace App\Modules\Auth\Command\JoinByEmail\Request;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email = '';

    #[Assert\Length(min: 6)]
    #[Assert\NotBlank]
    public string $password = '';
}
