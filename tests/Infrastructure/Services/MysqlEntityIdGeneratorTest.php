<?php
namespace TestController\Infrastructure\Services;

use TestCase;

/**
 * Test for Entity id generation.
 *
 * @package TestController
 *
 * @license Proprietary
 */
class MysqlEntityIdGeneratorTest extends TestCase
{
    public function testGenerate()
    {
        $generator = new MysqlEntityIdGenerator($this->app->make(\PDO::class));

        $id1 = $generator->generate();
        $id2 = $generator->generate();

        $this->assertEquals(1, $id2 - $id1);
    }
}
