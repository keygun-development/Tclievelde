<?php

/**
 * Registers the technique post type.
 */
function proa_register_user_fields()
{
    acf_add_local_field_group([
        "key" => "group_61df0880d13a7",
        "title" => "Extra data",
        "fields" => [
            [
                "key" => "field_61df0882f2585",
                "label" => "Lidnummer:",
                "name" => "user_player_number",
                'type' => 'number',
                'return_format' => 'array',
                "instructions" => "",
                "required" => 1,
                "conditional_logic" => 0,
                "min" => 1000,
                "max" => 9999
            ],
        ],
        "location" => [
            [
                [
                    "param" => "user_form",
                    "operator" => "==",
                    "value" => "all",
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
        "show_in_rest" => 0,
        "modified" => 16421691972
    ]);
}

add_action('init', 'proa_register_user_fields');
