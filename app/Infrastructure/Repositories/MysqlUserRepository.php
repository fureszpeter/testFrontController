<?php
namespace TestController\Infrastructure\Repositories;

use OutOfBoundsException;
use PDO;
use RuntimeException;
use TestController\Domain\Entities\User;
use TestController\Domain\Repositories\UserRepository;
use TestController\Domain\ValueObjects\Email;
use TestController\Infrastructure\Contracts\Services\EntityIdSetter;

/**
 * MySql implementation of UserRepository.
 *
 * @package TestController
 *
 * @license Proprietary
 */
class MysqlUserRepository implements UserRepository
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var \TestController\Infrastructure\Contracts\Services\EntityIdSetter
     */
    private $idSetter;

    /**
     * MysqlUserRepository constructor.
     *
     * @param \PDO $pdo
     * @param \TestController\Infrastructure\Contracts\Services\EntityIdSetter $idSetter
     */
    public function __construct(PDO $pdo, EntityIdSetter $idSetter)
    {
        $this->pdo = $pdo;
        $this->idSetter = $idSetter;
    }

    /**
     * @return \TestController\Domain\Entities\User[]
     */
    public function fetchAll()
    {
        $stmt = $this->pdo->prepare("SELECT `id`, `name`, `email`, `password` FROM users");
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($stmt->fetchAll() as $result) {
            $user = (new User(new Email($result['email'])))
                ->setName($result['name'])
                ->setPassword($result['password']);
            $this->idSetter->setEntityId($user, $result['id']);

            $users[] = $user;
        }

        return $users;
    }

    /**
     * {@inheritdoc}
     */
    public function save(User $user)
    {
        $stmt = $this->pdo->prepare('INSERT INTO users(`name`, `email`, `password`) VALUES (:name, :email, :password)');
        $result = $stmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ]);

        if (! $result) {
            throw new RuntimeException('Unable to save User Entity! ' . $stmt->errorInfo()[2]);
        }

        $this->idSetter->setEntityId($user, (int) $this->pdo->lastInsertId());

        return $user;
    }

    /**
     * @param string $entityId
     *
     * @throws \OutOfBoundsException If user not found.
     *
     * @return \TestController\Domain\Entities\User
     */
    public function findById($entityId)
    {
        $stmt = $this->pdo->prepare("SELECT `id`, `name`, `email`, `password` FROM users WHERE id=?");
        $stmt->execute([$entityId]);

        return $this->executeStatement($stmt);
    }

    /**
     * @param \TestController\Domain\Entities\User $user
     *
     * @return bool
     */
    public function delete(User $user)
    {
        return $this->pdo->exec("DELETE FROM users WHERE id=" . $user->getId()) === true;
    }

    /**
     * @param \TestController\Domain\ValueObjects\Email $email
     *
     * @throws \OutOfBoundsException If user not found.
     *
     * @return \TestController\Domain\Entities\User
     */
    public function findByEmail(Email $email)
    {
        $stmt = $this->pdo->prepare("SELECT `id`, `name`, `email`, `password` FROM users WHERE email=?");
        $stmt->execute([$email]);

        return $this->executeStatement($stmt);
    }

    /**
     * @param $stmt
     *
     * @return $this
     */
    private function executeStatement($stmt)
    {
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetch();

        if (! $result) {
            throw new OutOfBoundsException("The requested user not found in our database.");
        }

        $user = (new User(new Email($result['email'])))
            ->setName($result['name'])
            ->setPassword($result['password']);
        $this->idSetter->setEntityId($user, $result['id']);

        return $user;
    }
}
