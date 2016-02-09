<?php
namespace TestController\Infrastructure\Repositories;

use OutOfBoundsException;
use TestCase;
use TestController\Domain\Entities\User;
use TestController\Domain\Repositories\UserRepository;
use TestController\Domain\ValueObjects\Email;

/**
 * Unit test for MySqlUserRepository.
 *
 * @package TestController
 *
 * @license Proprietary
 */
class MysqlUserRepositoryTest extends TestCase
{
    /**
     * @var \TestController\Domain\Repositories\UserRepository
     */
    private $userRepository;

    public function setUp()
    {
        parent::setUp();

        $userRepository = $this->app->make(UserRepository::class);

        $this->userRepository = $userRepository;
    }

    public function testShouldImplementUserRepository()
    {
        $this->assertInstanceOf(UserRepository::class, $this->userRepository);
    }

    public function testFetchAll()
    {
        $users = $this->userRepository->fetchAll();

        $this->assertContainsOnlyInstancesOf(User::class, $users);
    }

    public function testFindByIdIfExists()
    {
        $user = $this->userRepository->findById('1');

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('Test User 1', $user->getName());
        $this->assertEquals('test_1@example.com', $user->getEmail());
        $this->assertEquals('secret', $user->getPassword());
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testFindByIdIfNotExists()
    {
        $this->userRepository->findById('123');
    }

    public function testFindByEmailIfExists()
    {
        $user = $this->userRepository->findByEmail(new Email('test_1@example.com'));

        $this->assertEquals(1, $user->getId());
        $this->assertEquals('Test User 1', $user->getName());
        $this->assertEquals('test_1@example.com', $user->getEmail());
        $this->assertEquals('secret', $user->getPassword());
    }

    /**
     * @expectedException OutOfBoundsException
     */
    public function testFindByEmailIfNotExists()
    {
        $this->userRepository->findByEmail(new Email('test_1_not_exists@example.com'));
    }

    public function testDelete()
    {
        $user = new User(new Email('savedForDelete@email.com'));
        $user->setPassword('savedPassword')
            ->setName('Saved John');

        $savedUser = $this->userRepository->save($user);

        $this->assertEquals(
            $savedUser,
            $this->userRepository->findByEmail(new Email('savedForDelete@email.com'))
        );

        $this->userRepository->delete($savedUser);

        $this->setExpectedException(OutOfBoundsException::class);
        $this->userRepository->findByEmail(new Email('savedForDelete@email.com'));
    }

    public function testSave()
    {
        $user = new User(new Email('saved@email.com'));
        $user->setPassword('savedPassword')
            ->setName('Saved John');

        try {
            $toDelete = $this->userRepository->findByEmail($user->getEmail());
            $this->userRepository->delete($toDelete);
        } catch (OutOfBoundsException $e) {
        }

        $savedUser = $this->userRepository->save($user);
        $this->assertNotNull($savedUser->getId());

        $toDelete = $this->userRepository->findByEmail($user->getEmail());
        $this->userRepository->delete($toDelete);
    }
}
