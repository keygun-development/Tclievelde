<?php
/**
 * Register our sidebars and widgetized areas.
 */
function proa_sidebar_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html( 'Onder Header', 'nppl' ),
		'id'            => 'below_header',
		'description'   => esc_html( 'Widget-gebied onder header', 'nppl' ),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar(  array(
		'name'          => esc_html( 'Onder Footer', 'nppl' ),
		'id'            => 'below_footer',
		'description'   => esc_html( 'Widget-gebied onder footer', 'nppl' ),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar(  array(
		'name'          => esc_html( 'Boven Content', 'nppl'),
		'id'            => 'above_content',
		'description'   => esc_html( 'Widget-gebied above content', 'nppl' ),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );

	register_sidebar(  array(
		'name'          => esc_html( 'Onder Content', 'nppl'),
		'id'            => 'below_content',
		'description'   => esc_html( 'Widget-gebied onder content', 'nppl' ),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="u-h2">',
		'after_title'   => '</h3>',
	) );

	register_sidebar(  array(
		'name'          => esc_html( 'Dashboard Modal'),
		'id'            => 'dashboard_modal',
		'description'   => esc_html( 'Widget-gebied onder content' ),
		'before_widget' => '<div id="%1$s" class="%2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="u-h2">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'proa_sidebar_widgets_init' );
