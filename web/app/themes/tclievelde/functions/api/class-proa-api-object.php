<?php

namespace functions\api;

/**
 * Interface Proa_API_Object
 *
 * Adds functionality to build API responses
 */
interface Proa_API_Object {

    /**
     * @return string
     */
    public function getLink(): string;

    /**
     * @return array
     */
    public function getAPISuggestionData(): array;

    /**
     * @return string
     */
    public function getObjectType(): string;

    /**
     * @return array
     */
    public function getAPIData(): array;
}
