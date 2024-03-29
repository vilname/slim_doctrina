<?php

declare(strict_types=1);

namespace App\Modules\OAuth\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Entities\Traits\EntityTrait;
use League\OAuth2\Server\Entities\Traits\ScopeTrait;
use Webmozart\Assert\Assert;

class Scope implements ScopeEntityInterface
{
    use EntityTrait;
    use ScopeTrait;

    public function __construct(string $identifier)
    {
        Assert::notEmpty($identifier);

        $this->setIdentifier($identifier);
    }

    public function jsonSerialize(): mixed
    {
        return $this->getIdentifier();
    }
}
