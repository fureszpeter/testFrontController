<?php
namespace TestController\Domain\Entities;

use stdClass;
use TestCase;
use TestController\Domain\ValueObjects\Email;

/**
 * Test for User Entity.
 *
 * @package TestController
 *
 * @license Proprietary
 */
class UserTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testEmailIsMandatory()
    {
        new User();
    }

    public function testGetEmail()
    {
        $mockEmail = $this->getMockEmail();

        $user = new User($mockEmail);

        $this->assertSame($mockEmail, $user->getEmail());
    }

    public function testSetEmailGetEmail()
    {
        $firstEmail = $this->getMockEmail();

        $anotherEmail = $this->getMockEmail();

        $user1 = new User($firstEmail);

        $user2 = $user1->setEmail($anotherEmail);

        $this->assertEquals($user1, $user2);

        $this->assertSame($anotherEmail, $user2->getEmail());
    }

    public function testSetNameGetName()
    {
        $user1 = new User($this->getMockEmail());

        $user2 = $user1->setName('FirstName LastName');

        $this->assertEquals($user1, $user2);

        $this->assertEquals('FirstName LastName', $user2->getName());
    }

    public function testSetPasswordGetPassword()
    {
        $user1 = new User($this->getMockEmail());

        $user2 = $user1->setPassword('pAssWordAsString');

        $this->assertEquals($user1, $user2);

        $this->assertEquals('pAssWordAsString', $user2->getPassword());
    }

    /**
     * @dataProvider nonStringProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $invalidArgument
     */
    public function testSetNameWithInvalidValue($invalidArgument)
    {
        $user = new User($this->getMockEmail());

        $user->setName($invalidArgument);
    }

    /**
     * @dataProvider nonStringProvider
     *
     * @expectedException \InvalidArgumentException
     *
     * @param mixed $invalidArgument
     */
    public function testSetPasswordWithInvalidValue($invalidArgument)
    {
        $user = new User($this->getMockEmail());

        $user->setPassword($invalidArgument);
    }

    public function testDefaultValuesAreNull()
    {
        $user = new User($this->getMockEmail());

        $this->assertNull($user->getName());
        $this->assertNull($user->getPassword());
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\TestController\Domain\ValueObjects\Email
     */
    private function getMockEmail()
    {
        return $this->getMockBuilder(Email::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return array
     */
    public function nonStringProvider()
    {
        return [
            [123],
            [new stdClass()],
            [null],
        ];
    }
}
