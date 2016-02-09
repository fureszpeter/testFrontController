<?php
namespace TestController\Domain\ValueObjects;

use JsonSerializable;
use TestController\Infrastructure\Validation\TypeChecker;
use UnexpectedValueException;

/**
 * Class Email.
 *
 *
 * @license Proprietary
 */
class Email implements JsonSerializable
{
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     *
     * @param string $email
     */
    public function __construct($email)
    {
        $this->setEmail($email);
    }

    /**
     * @param string $email
     *
     * @throws \InvalidArgumentException If email is not a string
     * @throws \UnexpectedValueException If email is invalid
     *
     * @return $this
     */
    private function setEmail($email)
    {
        TypeChecker::assertString($email, '$email');

        /*
         * @TODO Change email filter
         *  Not suitable for production. For production, use SMTP check for filter email address.
         */
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new UnexpectedValueException();
        }

        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getEmail();
    }

    /**
     * {@inheritdoc}
     * @return string
     */
    function jsonSerialize()
    {
        return (string) $this;
    }
}
