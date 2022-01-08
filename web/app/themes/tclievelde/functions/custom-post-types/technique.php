<?php

/**
 * Registers the technique post type.
 */
function proa_register_technique_post_type() {
	register_post_type( 'technique',
		[
			'labels'        => [
				'name'               => esc_html__( 'Technieken', 'nppl' ),
				'singular_name'      => esc_html__( 'Techniek', 'nppl' ),
				'add_new'            => esc_html__( 'Voeg toe', 'nppl' ),
				'add_new_item'       => esc_html__( 'Voeg nieuwe techniek toe', 'nppl' ),
				'edit'               => esc_html__( 'Bewerken', 'nppl' ),
				'edit_item'          => esc_html__( 'Bewerk techniek', 'nppl' ),
				'new_item'           => esc_html__( 'Nieuwe techniek', 'nppl' ),
				'view'               => esc_html__( 'Toon techniek', 'nppl' ),
				'view_item'          => esc_html__( 'Toon techniek', 'nppl' ),
				'search_items'       => esc_html__( "Zoek technieken", 'nppl' ),
				'not_found'          => esc_html__( "Geen technieken gevonden", 'nppl' ),
				'not_found_in_trash' => esc_html__( "Geen technieken gevonden in prullenbak", 'nppl' ),
			],
			'public'        => true,
			'hierarchical'  => false,
			'has_archive'   => true,
			'menu_position' => 21,
			'menu_icon'     => 'dashicons-hammer',
			'can_export'    => true,
			'rewrite'       => [ 'slug' => 'techniek' ],
			'supports'      => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
			],
		]
	);
}

add_action( 'init', 'proa_register_technique_post_type' );
