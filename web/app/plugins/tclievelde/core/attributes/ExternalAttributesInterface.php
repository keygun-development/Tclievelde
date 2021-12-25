<?php

namespace Tclievelde\core\attributes;

/**
 * Interface ExternalAttributesInterface
 * @package Tclievelde\Core
 */
interface ExternalAttributesInterface
{
    /**
     * @param  $name
     *
     * @return mixed
     */
    public function loadAttribute($name);

    /**
     * @param array|null $selection
     *
     * @return self
     */
    public function loadAttributes(array $selection = null): AttributesInterface;

    /**
     * @param string $name
     *
     * @return self
     */
    public function storeAttribute(string $name): AttributesInterface;

    /**
     * @return AttributesInterface
     */
    public function storeAttributes(): AttributesInterface;
}
