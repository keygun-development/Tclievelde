<?php

/**
 * Class Proa_Site_Hero
 */
class Proa_Site_Hero {
	/**
	 * @var bool
	 */
	public $has_hero = false;

	public $hero_css = '';

	public $avatar = '';

	public $title = '';

	public $intro = '';

	public $label = '';

	public $background_wide = '';

	public $background_narrow = '';

	public $is_participant = false;

	public $is_technique = false;

	public $is_expert = false;
}

/**
 * @return Proa_Site_Hero
 */
function proa_site_hero_logic() {
	global $post;

	$site_hero = new Proa_Site_Hero();

	if ( ! class_exists( ACF::class ) ) {
		return $site_hero;
	}

	$site_hero->title             = trim( get_field( 'hero_title' ) );
	$site_hero->intro             = trim( get_field( 'hero_intro' ) );
	$site_hero->background_wide   = proa_get_proxy_to_image( trim( get_field( 'hero_background_wide' ) ) );
	$site_hero->background_narrow = proa_get_proxy_to_image( trim( get_field( 'hero_background_narrow' ) ) );

	$site_hero->is_participant 		= get_post_type() === 'participant';
	$site_hero->is_expert 			= get_post_type() === 'expert';
	$site_hero->is_technique   		= get_post_type() === 'technique';

	/** Disable hero if there are no background and is not expert page OR if the page is not singular (e.g. archive pages) OR on the front page. */
	if ( ( empty( $site_hero->background_wide ) && empty( $site_hero->background_narrow ) && ! $site_hero->is_expert ) || ! is_singular() || is_front_page()) {
		// var_dump("is not hero page.");
		return $site_hero;
	}

	$site_hero->has_hero = true;

	$site_hero->hero_css = sprintf(
		"<style>.c-site-hero { background-image: url(%s); }",
		$site_hero->background_narrow ?? $site_hero->background_wide
	);

	if ( ! empty( $site_hero->background_narrow ) && ! empty( $site_hero->background_wide ) ) {
		// Migrated from David's code.
		// $hero_css .= "@media (max-width:32em) { .c-site-hero--deelnemer { background-image: url($hero_bg_n); } }";

		$site_hero->hero_css .= sprintf(
			'@media (min-width:50em), (orientation:landscape) { .c-site-hero { background-image: url(%s); } }',
			esc_url( $site_hero->background_wide )
		);
	}

	$site_hero->hero_css .= '</style>';

	return $site_hero;
}
