<?php

namespace Tclievelde\core\customTaxonomies;

use Tclievelde\core\Localization\LocalizedName;
use Tclievelde\Tclievelde;

/**
 * Interface CustomTaxonomyTrait
 * @package posts
 */
trait CustomTaxonomyTrait
{
    /**
     * @return string
     */
    abstract public function getTaxonomyType(): string;

    /**
     * @return LocalizedName
     */
    abstract public function getName(): LocalizedName;

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
            'name'                       => esc_html__($plural, $this->getTaxonomyType()),
            'singular_name'              => esc_html__($singular, $domain),
            'add_new'                    => esc_html__("Voeg toe", $domain),
            'add_new_item'               => esc_html__("Voeg nieuwe $singular toe", $domain),
            'edit'                       => esc_html__("Bewerk", $domain),
            'edit_item'                  => esc_html__("Bewerk $singular", $domain),
            'new_item'                   => esc_html__("Nieuwe $singular", $domain),
            'view'                       => esc_html__("Toon $singular", $domain),
            'view_item'                  => esc_html__("Toon $singular", $domain),
            'search_items'               => esc_html__("Zoek $singular", $domain),
            'not_found'                  => esc_html__("Geen $plural gevonden", $domain),
            'not_found_in_trash'         => esc_html__("Geen $plural gevonden in prullenbak", $domain),
            'all_items'                  => esc_html__("Alle $plural"),
            'parent_item'                => null,
            'parent_item_colon'          => null,
            'update_item'                => esc_html__("Update $singular"),
            'new_item_name'              => esc_html__("Nieuw $singular"),
            'separate_items_with_commas' => esc_html__("$plural scheiden met comma's"),
            'add_or_remove_items'        => esc_html__("$singular toevoegen of verwijderen"),
            'choose_from_most_used'      => esc_html__("Kies van de meest gebruikte $plural"),
            'menu_name'                  => esc_html__($plural),
        ];
    }

    /**
     * @return void
     */
    public function registerTaxonomy(): void
    {
        register_taxonomy($this->getTaxonomyType(), ['post'], array(
            'hierarchical'          => true,
            'labels'                => $this->getLabels(),
            'show_ui'               => true,
            'show_admin_column'     => true,
            'update_count_callback' => '_update_post_term_count',
            'query_var'             => true,
            'rewrite'               => array( 'slug' => $this->getTaxonomyType() ),
            'show_in_rest'          => true
        ));
    }

    public function addActions(): void
    {
        add_action('init', [$this, 'register_taxonomy'], 10);
    }
}
