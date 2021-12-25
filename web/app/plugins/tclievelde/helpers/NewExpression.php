<?php

namespace Tclievelde\helpers;

/**
 * Trait NewExpression
 * @package Tclievelde\helpers
 */
trait NewExpression
{
    /**
     * @param mixed ...$arguments
     *
     * @return $this
     */
    public static function of(...$arguments): self
    {
        return new static(...$arguments);
    }
}
