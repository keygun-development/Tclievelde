<?php

namespace Tclievelde\core\search;

/**
 * Interface SearchTermInterface
 * @package Tclievelde\core\search
 */
interface SearchTermInterface
{
    /**
     * @return string
     */
    public function getKey();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function setValue($value);

    /**
     * Return the search term in a usable form.
     * E.g. ACF meta query item array for ACF.
     *
     * @return mixed
     */
    public function parse();
}
