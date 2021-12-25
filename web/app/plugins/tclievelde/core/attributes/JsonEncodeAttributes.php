<?php

namespace Tclievelde\core\attributes;

/**
 * Trait JsonEncodesAttributes
 * @package Tclievelde\core\attributes
 */
trait JsonEncodeAttributes
{
    /**
     * @param array|null $selection
     *
     * @return array
     */
    abstract public function getAttributes(array $selection = null): array;

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getAttributes();
    }
}
