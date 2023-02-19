<?php

declare(strict_types=1);

namespace App\Modules\Auth\Service;

use App\Modules\Auth\Entity\User\Token;
use DateInterval;
use DateTimeImmutable;
use Ramsey\Uuid\Uuid;

class Tokenizer
{
    private DateInterval $interval;

    public function __construct(DateInterval $interval)
    {
        $this->interval = $interval;
    }

    public function generate(DateTimeImmutable $date): Token
    {
        return new Token(
            Uuid::uuid4()->toString(),
            $date->add($this->interval)
        );
    }
}
