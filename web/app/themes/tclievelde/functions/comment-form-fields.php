<?php

/**
 * Remove the "website" field from the comment form.
 *
 * @param array $fields An array of fields.
 *
 * @return array
 */
function proa_remove_website_field( $fields ) {
	unset( $fields['url'] );

	return $fields;
}

add_filter( 'comment_form_default_fields', 'proa_remove_website_field' );

/**
 * Change the `wp-comment-cookies-consent` text to remove 'en website'
 * https://generatepress.com/forums/topic/edit-comment-cookies-text-save-my-name-email-and-website/#post-585895
 *
 * @param array $fields An array of fields
 *
 * @return array
 */
function proa_filter_comment_fields( $fields ) {
	$commenter         = wp_get_current_commenter();
	$consent           = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';
	$fields['cookies'] = '<p class="comment-form-cookies-consent">' .
	                     '<input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" ' . $consent . ' />&nbsp;' .
	                     '<label for="wp-comment-cookies-consent">Bewaar mijn naam en e-mailadres in deze browser voor de volgende keer wanneer ik een reactie plaats.</label>' .
	                     '</p>';

	return $fields;
}

add_filter( 'comment_form_default_fields', 'proa_filter_comment_fields', 20 );
