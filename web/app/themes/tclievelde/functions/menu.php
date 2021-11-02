<?php

/**
 * @param string $name
 *
 * @return bool
 */
function tclievelde_should_menu_item_highlight(string $name): bool
{
    return strtolower($name) === strtolower(tclievelde_get_section_type());
}


/**
 * Get all menu items with children based on the menu location.
 *
 * @param string $location
 *
 * @return array|false
 */
function tclievelde_get_menu_items_with_children(string $location)
{

    // Get all locations
    $object = wp_get_nav_menu_object($location);

    // Get menu items by menu name
    $navbar_items = wp_get_nav_menu_items($object->name);

    $child_items = [];

    // pull all child menu items into separate object
    foreach ($navbar_items as $key => $item) {
        if ($item->menu_item_parent) {
            array_push($child_items, $item);
            unset($navbar_items[$key]);
        }
    }

    // push child items into their parent item in the original object
    foreach ($navbar_items as $item) {
        foreach ($child_items as $key => $child) {
            if ($child->menu_item_parent == $item->ID) {
                if (!$item->child_items) {
                    $item->child_items = [];
                }

                array_push($item->child_items, $child);
                unset($child_items[$key]);
            }
        }
    }

    return $navbar_items;
}

/**
 * @return string
 */
function tclievelde_get_section_type(): string
{
    if (tclievelde_is_page_home()) {
        return 'homepage';
    }

    if (tclievelde_is_page_wedstrijden()) {
        return 'wedstrijden';
    }

    if (tclievelde_is_page_nieuwe_wedstrijd()) {
        return 'nieuwe-wedstrijd';
    }

    return 'general';
}

/**
 * @return mixed
 */
function tclievelde_get_template_name()
{
    return get_post_meta(get_the_ID(), '_wp_page_template', true);
}

/**
 * @return bool
 */
function tclievelde_is_page_wedstrijden()
{
    return in_array(tclievelde_get_template_name(), [
        'page-wedstrijden.php',
    ]);
}

/**
 * @return bool
 */
function tclievelde_is_page_home()
{
    return in_array(tclievelde_get_template_name(), [
            'page-homepage.php',
        ]);
}

/**
 * @return bool
 */
function tclievelde_is_page_nieuwe_wedstrijd()
{
    return in_array(tclievelde_get_template_name(), [
            'page-nieuwe-wedstrijd.php',
        ]);
}