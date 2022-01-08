<?php

/**
 * Renders the row required for the bubbles to align properly.
 *
 * @param null   $attributes
 * @param string $content
 *
 * @return string
 */
function proa_bubble_row( $attributes = null, $content = '' ) {
	return sprintf(
		'<section class="c-section"><div class="c-section__content"><ul class="o-grid-list o-grid-list--three o-grid-list--center">%s</ul></div></section>',
		do_shortcode( $content )
	);
}

/**
 * Renders a single bubble. An image (ID) is not required.
 *
 * @param array  $attributes
 * @param string $content
 *
 * @return false|string
 */
function proa_detail_bubble( $attributes = [], $content = '' ) {
	$attributes = shortcode_atts(
		[
			'image_id' => '',
			'heading' => '',
			'subheading' => '',
		],
		$attributes,
		'proa_detail_bubble'
	);

	$image_id  = (int) $attributes['image_id'];
	$image_url = wp_get_attachment_image_url( $image_id, 'author' );

	ob_start();
	require __DIR__ . '/detail-bubble-template.php';
	$output = ob_get_contents();
	ob_end_clean();

	return $output;

}

/** Register the shortcodes with WordPress. */
add_shortcode( 'proa_bubble_row', 'proa_bubble_row' );
add_shortcode( 'proa_detail_bubble', 'proa_detail_bubble' );