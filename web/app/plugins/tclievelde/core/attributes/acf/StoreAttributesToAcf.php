<?php

namespace Tclievelde\core\attributes\acf;

use Tclievelde\core\attributes\AttributesInterface;
use Tclievelde\core\models\ModelInterface;
use WP_Post;

trait StoreAttributesToAcf
{

    /**
     * @return ModelInterface
     */
    abstract public function getModel(): ModelInterface;

    /**
     * @return WP_Post
     */
    abstract public function getWpPost(): WP_Post;

    /**
     * @param string $name
     *
     * @return mixed
     */
    abstract public function getAttribute(string $name);

    /**
     * @return self
     */
    public function storeAttributes(): AttributesInterface
    {
        foreach ($this->getModel()->getAcfFieldNames() as $field_name) {
            $this->storeAttribute($field_name);
        }

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function storeAttribute(string $name): AttributesInterface
    {

        $method = 'store_' . $name;
        if (method_exists($this, $method)) {
            $this->$method();
            return $this;
        }

        try {
            update_field(
                $name,
                $this->getAttribute($name),
                $this->GetWpPost()
            );
        } catch (\Exception $exception) {
            // Most likely, the attribute $name hasn't been loaded nor set yet.
            // In any case, just ignore the attribute if it cannot be stored.
            // TODO: Maybe log? Attribute mapping is probably incorrect.
        }

        return $this;
    }
}
