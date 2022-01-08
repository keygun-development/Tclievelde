<?php
/**
 * Adds support for Featured Images
 *
 * @see        https://codex.wordpress.org/Post_Thumbnails
 *
 * @package    WordPress
 * @subpackage WP-proeftuinprecisielandbouw.nl
 */
add_theme_support( 'post-thumbnails' );

/**
 * Default Featured Image size
 *
 * @see https://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
 */
set_post_thumbnail_size( 220, 147, true ); //[ 'top', 'left' ] );

add_image_size( 'medium_large', 768, 768 );

/**
 * Register Image Sizes
 * Resize/crop uploaded images in Media Library
 *
 * @see https://developer.wordpress.org/reference/functions/add_image_size/
 */
add_image_size( '1col', 60, 40, true ); // [ 'top', 'left' ] );
add_image_size( '2col', 140, 93, true ); // [ 'top', 'left' ] );
add_image_size( '3col', 220, 147, true ); // [ 'top', 'left' ] );
add_image_size( '4col', 300, 200, true ); // [ 'top', 'left' ] );
add_image_size( '6col', 460, 307, true ); // [ 'top', 'left' ] );
add_image_size( 'wide', 800, 533, true ); // [ 'top', 'left' ] );
add_image_size( 'ankeiler', 368, 245, true ); // [ 'top', 'left' ] );

/* .c-card--image widescreen: 6:2 instead of 3:2 */
add_image_size( 'ankeiler-1', 720, 316, true ); // [ 'top', 'left' ] );

/**
 * Author Avatars are *square*
 * (so try and make sure uploaded image is square too)
 */
add_image_size( 'author', 320, 320, true ); // [ 'top', 'left' ] );


/**
 * Add our image sizes options to Media Uploader
 * Now they display in e.g 'Attachment Display' list
 */
add_filter( 'image_size_names_choose', 'proa_new_image_sizes' );

/**
 * Adds image sizes to the selection in WP admin.
 *
 * @param array $sizes Array of image sizes and their names. Default values include 'Thumbnail', 'Medium', 'Large',
 *                     'Full Size'.
 *
 * @return array
 */
function proa_new_image_sizes( $sizes ) {
	$add_sizes = [
		'1col'   => 'Thumbnail width',
		'2col'   => 'Small width',
		'3col'   => 'Medium width',
		'4col'   => 'Large width',
		'6col'   => 'Full width',
		'author' => 'Author Avatar',
	];

	return array_merge( $sizes, $add_sizes );
}