<?php

namespace Tclievelde\helpers;

/**
 * Trait newExpression
 * @package Tclievelde\helpers
 */
trait newExpression
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
