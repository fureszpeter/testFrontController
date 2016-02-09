<?php
namespace TestController\Infrastructure\Services;

use OutOfBoundsException;
use ReflectionClass;
use TestController\Infrastructure\Contracts\Services\EntityIdSetter;

/**
 * Set Entity id.
 *
 * @package TestController
 *
 * @license Proprietary
 */
class ReflectionEntityIdSetter implements EntityIdSetter
{
    /**
     * @param mixed $entity
     * @param mixed $id
     *
     * @return mixed
     */
    public function setEntityId($entity, $id)
    {
        $reflectionEntity = new ReflectionClass($entity);
        $properties = $reflectionEntity->getProperties();

        try {
            $property = $this->getProperty($properties, 'id');
            $property->setAccessible(true);
            $property->setValue($entity, $id);
            $property->setAccessible(false);
        } catch (OutOfBoundsException $e) {
            //If property not found, leave untouched
        }

        return $entity;
    }

    /**
     * @param \ReflectionProperty[] $properties
     * @param $name
     *
     * @return \ReflectionProperty
     */
    private function getProperty(array $properties, $name)
    {
        foreach ($properties as $property) {
            if ($property->getName() === $name) {
                return $property;
            }
        }

        throw new OutOfBoundsException('Property not found');
    }
}
