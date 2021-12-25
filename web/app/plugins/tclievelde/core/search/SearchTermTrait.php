<?php

namespace Tclievelde\core\search;

/**
 * Trait SearchTermTrait
 * @package Tclievelde\core\search
 */
trait SearchTermTrait
{
    /** @var string */
    private string $key;

    /** @var mixed|null */
    private $value;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Search_Term_Trait constructor.
     *
     * @param string     $key
     * @param mixed|null $value
     */
    public function __construct(string $key, $value = null)
    {
        $this->key   = $key;
        $this->value = $value;
    }
}
