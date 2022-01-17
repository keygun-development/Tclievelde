<?php

namespace functions\core;

/**
 * Class Proa_Post_Abstract
 */
abstract class Proa_Term_Abstract extends Proa_Object {

    /**
     * @param  array  $arguments
     * @return array
     */
    protected static function retrieve(array $arguments): array
    {
        $arguments['taxonomy'] = static::getIdentifier();
		$arguments['hide_empty'] = false;
        return get_terms($arguments);
    }

    /**
     * @return WP_Term
     */
    public function getTerm(): WP_Term
    {
        return $this->getWPObject();
    }

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->getTerm()->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->getTerm()->description;
    }
}
