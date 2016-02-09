<?php
namespace TestController\Domain\Repositories;

use TestController\Domain\Entities\User;
use TestController\Domain\ValueObjects\Email;

/**
 * Interface UserRepository.
 *
 * @package TestController
 *
 * @license Proprietary
 */
interface UserRepository
{
    /**
     * @return \TestController\Domain\Entities\User[]
     */
    public function fetchAll();

    /**
     * @param \TestController\Domain\Entities\User $user
     *
     * @throws \RuntimeException If unable to save the object.
     *
     * @return \TestController\Domain\Entities\User
     */
    public function save(User $user);

    /**
     * @param \TestController\Domain\Entities\User $user
     *
     * @return bool
     */
    public function delete(User $user);

    /**
     * @param string $entityId
     *
     * @throws \OutOfBoundsException If user not found.
     *
     * @return \TestController\Domain\Entities\User
     */
    public function findById($entityId);

    /**
     * @param \TestController\Domain\ValueObjects\Email $email
     *
     * @throws \OutOfBoundsException If user not found.
     *
     * @return \TestController\Domain\Entities\User
     */
    public function findByEmail(Email $email);
}
