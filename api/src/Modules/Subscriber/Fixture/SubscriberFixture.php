<?php

declare(strict_types=1);

namespace App\Modules\Subscriber\Fixture;

use App\Modules\Subscriber\Entity\Subscriber;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Persistence\ObjectManager;

class SubscriberFixture extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<=5; $i++) {
            $subscriber = Subscriber::create('user' . $i . '@mail.ru');

            $manager->persist($subscriber);
        }

        $manager->flush();
    }
}