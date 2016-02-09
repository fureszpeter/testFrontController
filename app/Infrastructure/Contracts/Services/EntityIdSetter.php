<?php
namespace TestController\Infrastructure\Contracts\Services;

/**
 * Set id for Entities through Reflection
 *
 * @package TestController
 */
interface EntityIdSetter
{
    /**
     * @param mixed $entity
     *
     * @param mixed $id
     *
     * @return mixed
     */
    public function setEntityId($entity, $id);
}
