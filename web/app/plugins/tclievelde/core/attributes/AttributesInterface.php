<?php

namespace Tclievelde\core\attributes;

/**
 * Interface AttributesInterface
 * @package Tclievelde\Core
 */
interface AttributesInterface
{
    /**
     * @param string $name
     * @param mixed $value
     *
     * @return self  As of PHP 7.4, the actual return type should be changed to "self".
     *               Implementing classes should return itself, so the actual return type
     *               can be any type, as long as it implements AttributesInterface.
     */
    public function setAttribute(string $name, $value): AttributesInterface;

    /**
     * @param string $name
     *
     * @return mixed|null
     */
    public function getAttribute(string $name);

    /**
     * @return array
     */
    public function getAttributes(): array;

    /**
     * @param array $key_values
     *
     * @return self
     */
    public function setAttributes(array $key_values): AttributesInterface;
}
