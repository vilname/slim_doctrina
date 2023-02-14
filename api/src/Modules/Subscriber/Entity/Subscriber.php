<?php

declare(strict_types=1);

namespace App\Modules\Subscriber\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: 'subscribers')]
class Subscriber
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue(strategy: 'AUTO')]
    private int $id;

    #[ORM\Column(type: 'string', unique: true)]
    private string $email;

    #[ORM\Column(type: 'datetime_immutable', columnDefinition:"TIMESTAMP DEFAULT CURRENT_TIMESTAMP")]
    private \DateTimeImmutable $created;

    public static function create(string $email): self
    {
        $self = new self();

        $self->email = $email;

        return $self;
    }
}
