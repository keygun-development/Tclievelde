<?php

namespace Tclievelde\core\models;

/**
 * Interface ACF_Mapping_Interface
 * @package Tclievelde\core\models
 */
interface AcfFieldsInterface
{
    /**
     * @return array
     */
    public function getAcfFieldNames(): array;
}
