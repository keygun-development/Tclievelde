<?php

/**
 * Registers the technique post type.
 */

function proa_register_reservation()
{
    proa_register_reservation_post_type();
    proa_register_reservation_fields();
}
function proa_register_reservation_post_type()
{
    register_post_type(
        'reservation',
        [
            'labels' => [
                'name' => esc_html__('Reserveringen', 'tclievelde'),
                'singular_name' => esc_html__('Reservering', 'tclievelde'),
                'add_new' => esc_html__('Voeg toe', 'tclievelde'),
                'add_new_item' => esc_html__('Voeg een nieuwe reservering toe', 'tclievelde'),
                'edit' => esc_html__('Bewerken', 'tclievelde'),
                'edit_item' => esc_html__('Bewerk reservering', 'tclievelde'),
                'new_item' => esc_html__('Nieuw reservering', 'tclievelde'),
                'view' => esc_html__('Toon reservering', 'tclievelde'),
                'view_item' => esc_html__('Toon reservering', 'tclievelde'),
                'search_items' => esc_html__("Zoek naar reservering", 'tclievelde'),
                'not_found' => esc_html__("Geen reservering gevonden", 'tclievelde'),
                'not_found_in_trash' => esc_html__("Geen reservering gevonden in prullenbak", 'tclievelde'),
            ],
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'hierarchical' => false,
            'has_archive' => false,
            'menu_position' => 21,
            'menu_icon' => 'dashicons-testimonial',
            'can_export' => true,
            'rewrite' => ['slug' => 'reserveringen'],
            'show_in_rest' => true,
            'supports' => [
                'title',
                'editor',
                'thumbnail',
                'custom-fields',
            ],
        ],
    );
}

function proa_register_reservation_fields()
{
    acf_add_local_field_group([
        "key" => "group_61a8c77e88148",
        "title" => "Reservering Data",
        "fields" => [
            [
                "key" => "field_61a9f8bb8jsnb",
                "label" => "Auteur ID:",
                "name" => "reservation_author",
                'type' => 'user',
                "instructions" => "",
                "required" => 1,
                "conditional_logic" => 0,
            ],
            [
                "key" => "field_61a9f8bb8a165",
                "label" => "Datum en tijd van:",
                "name" => "reservation_date_time_start",
                'type' => 'date_time_picker',
                'display_format' => 'd/m/Y H:i',
                'return_format' => 'Y-m-d H:i',
                'first_day' => 1,
                "instructions" => "",
                "required" => 1,
                "conditional_logic" => 0,
            ],
            [
                "key" => "field_61a9f8bb78nhs",
                "label" => "Tijd tot:",
                "name" => "reservation_time_end",
                'type' => 'date_time_picker',
                'display_format' => 'd/m/Y H:i',
                'return_format' => 'Y-m-d H:i',
                'first_day' => 1,
                "instructions" => "",
                "required" => 1,
                "conditional_logic" => 0,
            ],
            [
                "key" => "field_61a9f7b7a3d32",
                "label" => "Baan",
                "name" => "reservation_court",
                "type" => "select",
                "instructions" => "",
                "required" => 1,
                "conditional_logic" => 0,
                "choices" => [
                    "1" => "1",
                    "2" => "2",
                ],
                "default_value" => false,
                "allow_null" => 0,
                "multiple" => 0,
                "ui" => 0,
                "return_format" => "value",
                "ajax" => 0,
                "placeholder" => "",
            ],
            [
                'key' => 'field_61c18b86ee6fd',
                'label' => 'Medespelers',
                'name' => 'related_player',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'return_format' => 'object',
                'max' => 3,
                'sub_fields' => [
                    [
                        'key' => 'field_61bca85580de3',
                        'label' => 'Medespelers',
                        'name' => 'reservation_participant',
                        'type' => 'user',
                        'instructions' => '',
                        "role" => [
                            "subscriber"
                        ],
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => [
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ],
                    ]
                ],
            ],
        ],
        "location" => [
            [
                [
                    "param" => "post_type",
                    "operator" => "==",
                    "value" => "reservation",
                ],
            ],
        ],
        "menu_order" => 0,
        "position" => "normal",
        "style" => "default",
        "label_placement" => "top",
        "instruction_placement" => "label",
        "hide_on_screen" => "",
        "active" => true,
        "description" => "",
        "modified" => 1638545628,
    ]);
}

add_action('init', 'proa_register_reservation');
