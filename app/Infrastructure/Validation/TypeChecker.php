<?php
namespace TestController\Infrastructure\Validation;

use InvalidArgumentException;

/**
 * Class TypeChecker.
 *
 * @package TestController
 *
 * @license Proprietary
 */
class TypeChecker
{
    /**
     * @param mixed $value
     * @param string $variableName
     *
     * @throws \InvalidArgumentException if second parameter is not a string
     * @throws \InvalidArgumentException if first parameter is not a string
     *
     * @return bool
     */
    public static function assertString($value, $variableName)
    {
        if (! is_string($variableName)) {
            throw new InvalidArgumentException('$variableName should be a string');
        }

        if (! is_string($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s should be a string. [Received type: %s]',
                    $variableName,
                    gettype($value)
                )
            );
        }

        return true;
    }

    /**
     * @param int $value
     * @param string $variableName
     *
     * @throws \InvalidArgumentException If $variableName is not string
     * @throws \InvalidArgumentException If $value is not integer
     *
     * @return bool
     */
    public static function assertInt($value, $variableName)
    {
        if (! is_string($variableName)) {
            throw new InvalidArgumentException('$variableName should be a string');
        }

        if (! is_int($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    '%s should be an integer. [Received type: %s]',
                    $variableName,
                    gettype($value)
                )
            );
        }

        return true;
    }
}
