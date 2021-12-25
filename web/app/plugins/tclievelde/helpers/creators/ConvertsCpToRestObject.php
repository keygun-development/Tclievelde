<?php

namespace Tclievelde\helpers\creators;

use Tclievelde\core\api\RestObject;
use Tclievelde\core\api\RestConvertable;
use Tclievelde\core\attributes\AttributesInterface;

/**
 * Class ConvertsCpToApiObject
 * @package Tclievelde\core\attributes
 */
trait ConvertsCpToRestObject
{
    /**
     * @param array|null $selection
     *
     * @return array
     */
    abstract public function getAttributes(array $selection = null): array;

    /**
     * @param string $name
     * @param $value
     *
     * @return AttributesInterface
     */
    abstract public function setAttribute(string $name, $value): AttributesInterface;

    /**
     * @return \WP_Post
     */
    abstract public function getWpPost(): \WP_Post;

    /**
     * @param array|null $attribute_selection
     *
     * @return mixed
     */
    public function toRestObject(array $attribute_selection = null)
    {
        if (empty($this->getAttributes($attribute_selection))) {
            return $this->getWpPost()->ID;
        }

        foreach ($this->getAttributes($attribute_selection) as $key => $value) {
            if ($value instanceof RestConvertable) {
                $this->setAttribute($key, $value->toRestObject());
            }
        }

        return new RestObject(
            $this->getWpPost()->ID,
            $this->getWpPost()->post_type,
            $this->getAttributes($attribute_selection),
            get_post_permalink($this->getWpPost())
        );
    }
}
