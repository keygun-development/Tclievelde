<?php

namespace Tclievelde\helpers;

/**
 * Trait DisplaysView
 * @package Tclievelde\helpers
 */
trait DisplaysView
{
    /**
     * @return void
     */
    public function show(): void
    {
        echo $this->getView();
    }

    /**
     * @return string
     */
    abstract public function getView(): string;
}
