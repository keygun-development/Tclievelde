<?php

namespace Tclievelde\core\search;

use Tclievelde\core\attributes\AttributesInterface;

/**
 * Trait SetsAttributesByArray
 * @package Tclievelde\customPostTypes\search
 */
trait SetsAttributesByArray
{
    /**
     * @param string $name
     * @param mixed $value
     *
     * @return mixed
     */
    abstract public function setAttribute(string $name, $value): AttributesInterface;

    /**
     * @param array $values
     *
     * @return AttributesInterface
     */
    public function setAttributes(array $values): AttributesInterface
    {
        foreach ($values as $key => $value) {
            if ($value === null) {
                continue;
            }

            if (is_string($value)) {
                if (strlen($value) === 0) {
                    continue;
                }
            }

            $this->setAttribute($key, $value);
        }

        return $this;
    }
}
