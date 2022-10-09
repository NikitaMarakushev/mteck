<?php

declare(strict_types=1);

namespace App\Tests\Functional\Users\Infrastructure\Repository;

use App\Tests\Tools\FakerTool;
use App\User\Domain\Factory\UserFactory;
use App\User\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserRepositoryTest extends WebTestCase
{
    use FakerTool;

    private UserRepository $userRepository;

    protected function setUp(): void
    {
        self::markTestSkipped();
        parent::setUp();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    /**
     * Пользователь успешно добавлен.
     */
    public function testUserAddedSuccessfully(): void
    {
        $user = (new UserFactory())->create(
            $this->getFaker()->email(),
            $this->getFaker()->password()
        );

        $this->userRepository->add($user);

        $existingUser = $this->userRepository->findByUlid($user->getUlid());
        self::assertEquals($user->getUlid(), $existingUser->getUlid());
    }

    public function testUserFoundSuccessfully(): void
    {
        $user = (new UserFactory())->create(
            $this->getFaker()->email(),
            $this->getFaker()->password()
        );

        $this->userRepository->add($user);
        $existingUser = $this->userRepository->findByUlid($user->getUlid());

        self::assertEquals($user->getUlid(), $existingUser->getUlid());
    }
}