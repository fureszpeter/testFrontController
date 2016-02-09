<?php
namespace TestController\Infrastructure\Contracts\Services;

/**
 * Generate unique ID for entities
 *
 * @package TestController
 */
interface EntityIdGenerator
{
    /**
     * @return string
     */
    public function generate();
}
