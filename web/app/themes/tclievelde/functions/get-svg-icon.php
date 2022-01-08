<?php

/**
 * Returns a custom <svg> Sprite Icon tag
 * https://css-tricks.com/svg-sprites-use-better-icon-fonts/
 *
 * @param string $icon_name
 * @param string $alt
 * @param bool   $do_echo
 *
 * @return string
 */
function proa_get_svg_icon( $icon_name, $alt = '', $do_echo = true ) {

	if ( empty( $icon_name ) ) {
		return '';
	}

	$replacements = [ '!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]" ];
	$iconID       = strtolower( str_replace( $replacements, "", $icon_name ) );

	$aria = empty( $alt ) ? 'aria-hidden="true"' : 'aria-label="' . $alt . '"';

	$spriteFilePath = '/svg/sprite/symbol/sprite.svg';

	// NOTE: $sprite_file_time added to URL to use as cache-busting
	$sprite_file_time = filemtime( get_template_directory() . '/assets' . $spriteFilePath );
	// $sprite_file_url  = proa_get_asset_path() . $spriteFilePath . '#' . $iconID;
	$sprite_file_url = proa_get_asset_path() . $spriteFilePath . '?' . $sprite_file_time . '#' . $iconID;

	$svg_tag = sprintf(
		'<svg class="o-icon o-icon--%s" %s><use xlink:href="%s"></use></svg>',
		$iconID,
		$aria,
		$sprite_file_url
	);

	// Finally return out the constructed SVG Sprite tag.
	if ( ! $do_echo ) {
		return $svg_tag;
	}

	echo $svg_tag;
}
