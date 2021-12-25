<?php

namespace Tclievelde\core\attributes;

use Exception;

trait AttributesTrait
{

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @return array
     */
    abstract public function getFieldNames(): array;

    /**
     * @param string $name
     * @param $value
     *
     * @return self
     */
    public function setAttribute(string $name, $value): AttributesInterface
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAttributes(array $selection = null): array
    {
        if (! $selection || empty($selection)) {
            return $this->attributes;
        }

        $attributes = [];

        foreach ($selection as $key) {
            $attributes[ $key ] = $this->getAttribute($key);
        }

        return $attributes;
    }

    /**
     * @param array $key_values
     *
     * @return self
     */
    public function setAttributes(array $key_values): AttributesInterface
    {
        foreach ($key_values as $key => $value) {
            $this->setAttribute($key, $value);
        }

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAttribute(string $name)
    {
        if (!array_key_exists($name, $this->attributes)) {
            return null;
        }

        return $this->attributes[$name];
    }

    /**
     * @param $name
     *
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        if (in_array($name, $this->getFieldNames())) {
            return $this->getAttribute($name);
        }

        return $this->$name;
    }

    /**
     * @param $name
     * @param $value
     *
     * @return self
     */
    public function __set($name, $value)
    {
        if (in_array($name, $this->getFieldNames())) {
            return $this->setAttribute($name, $value);
        }

        $this->$name = $value;

        return $this;
    }
}
