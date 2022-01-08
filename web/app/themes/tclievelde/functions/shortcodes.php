<?php

/**
 * @param array $attributes
 * @param null  $content
 *
 * @return string
 */
function proa_shortcode_button( $attributes, $content = null ) {
	return '<div class="u-button-wrap">' . do_shortcode( $content ) . '</div>'; // do_shortcode allows for nested Shortcodes.
}

add_shortcode( 'proa_button', 'proa_shortcode_button' ); // You can place [proa_shortcode_button] in Pages, Posts now.


/**
 * @param array $attributes
 * @param null  $content
 *
 * @return string
 */
function proa_shortcode_row( $attributes, $content = null ) {
	return '<div class="o-row">' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'row', 'proa_shortcode_row' );


/**
 * @param array $attributes
 * @param null  $content
 *
 * @return string
 */
function proa_shortcode_col( $attributes, $content = null ) {
	return '<div class="o-col">' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'col', 'proa_shortcode_col' );


/**
 * @param array $attributes
 * @param null  $content
 *
 * @return string
 */
function proa_shortcode_col_text( $attributes, $content = null ) {
	return '<div class="u-text-columns">' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'col-text', 'proa_shortcode_col_text' );


/**
 * @param array       $attributes
 * @param null|string $content
 *
 * @return string
 */
function proa_shortcode_read_more( $attributes, $content = null ) {
	/* Setup (default) attributes, if any: https://codex.wordpress.org/Function_Reference/shortcode_atts */
	$attributes = shortcode_atts(
		array(
			'link' => null,
		), $attributes, 'read-more'
	);

	$link = $attributes['link'];

	return sprintf(
		'<div class="c-read-more">%s%s%s</div>',
		( ! empty( $link ) ) ? '<a href="' . esc_url_raw($link) . '">' : '',
		wpautop( $content ),
		$link_after = ( ! empty( $link ) ) ? '</a>' : ''
	);
}

add_shortcode( 'read-more', 'proa_shortcode_read_more' );
