<?php

declare(strict_types=1);

namespace App\Modules\OAuth\Command\ClearExpiredItems;

class Command
{
    public string $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }
}
