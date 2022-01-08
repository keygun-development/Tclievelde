<?php

/**
 * Handles the shortcode displaying for Proa_Objects.
 *
 * @param Proa_Post $callable           The object to display the shortcode for.
 * @param  array      $defined_attributes The attributes that can be defined.
 * @param  array      $attributes_input   The attributes that are actually given through the shortcode.
 * @param  string     $template           The ankeiler template to use.
 *
 * @return string|null
 */
function proa_object_shortcode_handler( Proa_Post $callable, $defined_attributes, $attributes_input, $template ) {
	if ( ! file_exists( $template ) ) {
		if ( current_user_can( 'administrator' ) ) {
			echo 'The specified template for the ' . $callable::getIdentifier() . ' shortcode could not be found.';
		}

		return;
	}

	$default_defined_attributes = [
		'limit' => '6',
	];

	$defined_attributes = array_merge( $default_defined_attributes, $defined_attributes );
	$attributes         = shortcode_atts( $defined_attributes, $attributes_input );

	$meta_query = array_map( function ( $key, $value ) {
		/** The limit is not part of the meta query, but a separate argument. */
		if ( $key === 'limit' || empty( $value ) ) {
			return false;
		};

		return [
			'key'     => $key,
			'value'   => $value,
			'compare' => '=',
		];
	}, array_keys( $attributes ), $attributes );

	/**
	 * The meta query may hold some empty values or false values at this point. The array_filter will clear
	 * these from the array.
	 */
	$meta_query = array_filter( $meta_query, function ( $element ) {
		return ( $element );
	} );

	$limit           = (int) $attributes['limit'];
	$objects         = $callable::findBy( $meta_query, $limit );
	$object_variable = 'proa_' . $callable::getIdentifier();

	ob_start();
	echo '<ul class="o-grid-list o-grid-list--three">';
	/** The ankeiler template expects a specific variable to pull its information from, that's set here. */
	foreach ( $objects as ${$object_variable} ) {
		echo '<li>';
		require $template;
		echo '</li>';
	}
	echo '</ul>';

	$return_content = ob_get_contents();
	ob_end_clean();

	return $return_content;
}


/**
 * Returns the required markup for the technique shortcode.
 *
 * @param array $attributes
 *
 * @return string|null
 */
function proa_shortcode_techniques( $attributes ) {
	return proa_object_shortcode_handler(
		new Proa_Technique(),
		[
			'year' => null,
		],
		$attributes,
		__DIR__ . '/../template-parts/ankeiler-technique.php' );
}

add_shortcode( 'proa_techniques', 'proa_shortcode_techniques' );

/**
 * Handles the shortcode for experts.
 *
 * @param array $attributes
 *
 * @return string|null
 */
function proa_shortcode_experts( $attributes ) {
	return proa_object_shortcode_handler(
		new Proa_Expert(),
		[
			'year' => null,
		],
		$attributes,
		__DIR__ . '/../template-parts/ankeiler-expert.php' );
}

add_shortcode( 'proa_experts', 'proa_shortcode_experts' );


/**
 * Handles the shortcode for participants.
 *
 * @param array $attributes
 *
 * @return string|null
 */
function proa_shortcode_participants( $attributes ) {
	return proa_object_shortcode_handler(
		new Proa_Participant(),
		[
			'year' => null,
		],
		$attributes,
		__DIR__ . '/../template-parts/ankeiler-participant.php'
	);
}

add_shortcode('proa_participants', 'proa_shortcode_participants');
