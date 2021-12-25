<?php

namespace Tclievelde\core\models;

use Exception;
use Tclievelde\core\Localization\LocalizedName;
use Tclievelde\Tclievelde;

/**
 * Trait model_trait
 * @package Tclievelde\Core\Models
 */
trait ModelTrait
{
    /**
     * @return string
     */
    abstract public function getPostType(): string;

    /**
     * @return array
     */
    public function getLabels(): array
    {
        $name = $this->getName();

        $singular = $name->getSingular();
        $plural   = $name->getPlural();

        $domain = Tclievelde::getDomain();

        return [
            'name'               => esc_html__($plural, $this->getPostType()),
            'singular_name'      => esc_html__($singular, $domain),
            'add_new'            => esc_html__("Voeg toe", $domain),
            'add_new_item'       => esc_html__("Voeg nieuwe $singular toe", $domain),
            'edit'               => esc_html__("Bewerk", $domain),
            'edit_item'          => esc_html__("Bewerk $singular", $domain),
            'new_item'           => esc_html__("Nieuwe $singular", $domain),
            'view'               => esc_html__("Toon $singular", $domain),
            'view_item'          => esc_html__("Toon $singular", $domain),
            'search_items'       => esc_html__("Zoek $singular", $domain),
            'not_found'          => esc_html__("Geen $plural gevonden", $domain),
            'not_found_in_trash' => esc_html__("Geen $plural gevonden in prullenbak", $domain),
        ];
    }

    /**
     * @return ModelInterface
     * @throws Exception
     */
    public function getModel(): ModelInterface
    {
        if ($this instanceof ModelInterface) {
            return $this;
        }

        throw new Exception('This trait should only be used on classes implementing Model_Interfaces.');
    }
}
