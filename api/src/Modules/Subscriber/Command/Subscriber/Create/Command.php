<?php

declare(strict_types=1);

namespace App\Modules\Subscriber\Command\Subscriber\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\Email()
     */
    public string $email;
}