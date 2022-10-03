<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use Doctrine\Persistence\ObjectManager;
use App\Tests\Resource\Fixture;

class UserFixture extends Fixture
{
    use FakerTool;

    public const REFERENCE = 'user';

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setName($this->getFaker()->name());
        $user->setEmail($this->getFaker()->email());
        $user->setPassword($this->getFaker()->password());
        $user->setIsVerified(true);

        $manager->persist($user);
        $manager->flush();

        $this->addReference(self::REFERENCE, $user);
    }
}
