<?php

/**
 * Returns the posts which title contains the given posts_title_like
 *
 * @param  $where
 * @param  $wp_query
 * @return string
 */
add_filter('wp_get_attachment_image_src', 'proa_apply_image_proxy');
add_filter('wp_get_the_post_thumbnail_url', 'proa_apply_image_proxy');

/**
 * Appends the query to retrieve the posts in which title contains the given posts_title_like.
 *
 * @param  $where
 * @param  $wp_query
 * @return string
 */
function posts_title_like( $where, $wp_query ) {
    global $wpdb;

    if ( $posts_title_like = $wp_query->get( 'posts_title_like' ) ) {
        $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $posts_title_like ) ) . '%\'';
    }

    return $where;
}

add_filter('wp_get_attachment_image_src', 'proa_apply_image_proxy');
add_filter('wp_get_the_post_thumbnail_url', 'proa_apply_image_proxy');

/**
 * Replaces the $url's domain name to the proxy domain name.
 * Returns the result.
 *
 * @param  $url
 *
 * @return mixed
 */
function proa_apply_image_proxy($url)
{
    if ( ! is_string($url)) {
        return $url;
    }

    return str_replace(
        WP_HOME,
        sprintf('https://%s', FRV_IMAGE_PROXY_HOST),
        $url
    );
}


function custom_excerpt_length($length)
{
    return 20;
}
add_filter('excerpt_length', 'custom_excerpt_length', 999);