<?php

namespace functions\core;

interface Proa_Base_Properties {

    /**
     * @return string
     */
    public function getTitle(): string;

    /**
     * @return string
     */
    public function getDescription(): string;
}