<?php

namespace Tclievelde\core\api;

/**
 * Interface RestConvertable
 * @package Tclievelde\api
 */
interface RestConvertable
{
    /**
     * @param array|null $attibute_selection
     *
     * @return mixed
     */
    public function toRestObject(array $attibute_selection = null);
}
