<?php
namespace TestController\Domain\ValueObjects;

use TestCase;
use UnexpectedValueException;

/**
 * Test for Email ValueObject.
 *
 *
 * @license Proprietary
 */
class EmailTest extends TestCase
{
    /**
     * @expectedException \ErrorException
     */
    public function testEmailIsRequiredShouldFail()
    {
        new Email();
    }

    /**
     * @dataProvider validEmailProvider
     *
     * @param string $emailAsString
     */
    public function testEmailWithValidValues($emailAsString)
    {
        $email = new Email($emailAsString);

        $this->assertEquals($emailAsString, $email->getEmail());
    }

    /**
     * @dataProvider validEmailProvider
     *
     * @param string $emailAsString
     */
    public function testCastToString($emailAsString)
    {
        $email = new Email($emailAsString);

        $this->assertEquals($emailAsString, (string) $email);
    }

    /**
     * @dataProvider invalidEmailProvider
     *
     * @param string $emailAsString
     * @param string $expectedException
     */
    public function testEmailWithInvalidValues($emailAsString, $expectedException)
    {
        $this->setExpectedException($expectedException);

        new Email($emailAsString);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testAcceptStringOnly()
    {
        new Email(123);
    }

    /**
     * @return array
     */
    public function validEmailProvider()
    {
        return [
            ['validemail@example.com'],
            ['valid.email@example.com'],
            ['valid.email@example.co.uk'],
            ['can.hold.numbers.1980@example.co.uk'],
        ];
    }

    /**
     * @return array
     */
    public function invalidEmailProvider()
    {
        return [
            ['invalidEmail', UnexpectedValueException::class],
            ['1123', UnexpectedValueException::class],
        ];
    }
}
