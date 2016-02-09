<?php
namespace TestController\Domain\Entities;

use JsonSerializable;
use TestController\Domain\ValueObjects\Email;
use TestController\Infrastructure\Validation\TypeChecker;

/**
 * Basic User Entity.
 *
 * @package TestController
 *
 * @license Proprietary
 */
class User implements JsonSerializable
{
    /**
     * @var int|null
     */
    private $id;

    /**
     * @var \TestController\Domain\ValueObjects\Email
     */
    private $email;

    /**
     * @var string|null
     */
    private $name;

    /**
     * @var string|null
     */
    private $password;

    /**
     * @param \TestController\Domain\ValueObjects\Email $email
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \TestController\Domain\ValueObjects\Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param \TestController\Domain\ValueObjects\Email $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        TypeChecker::assertString($name, '$name');

        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        TypeChecker::assertString($password, '$password');

        $this->password = $password;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'email' => $this->getEmail(),
        ];
    }
}
