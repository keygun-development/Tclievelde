<?php

namespace Tclievelde\core\attributes\acf;

use Tclievelde\core\attributes\AttributesInterface;
use Tclievelde\core\models\ModelInterface;
use WP_Post;

trait LoadAttributesFromAcf
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
     * @param array|null $selection
     *
     * @return self
     */
    public function loadAttributes(array $selection = null): AttributesInterface
    {
        if (!$selection) {
            $selection = $this->getModel()->getAcfFieldNames();
        }

        foreach ($selection as $field_name) {
            $this->loadAttribute($field_name);
        }

        return $this;
    }

    public function loadAttribute($name)
    {
        $method = 'load_' . $name;
        if (method_exists($this, $method)) {
            $this->$method();
            return $this;
        }

        $this->setAttribute($name, get_field($name, $this->getWpPost()));
        return $this;
    }
}
