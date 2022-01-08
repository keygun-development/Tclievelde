<?php

/**
 * Returns Asset path of current Theme
 *
 * @return string asset path url escaped
 */
function proa_get_asset_path()
{
    return esc_url(get_template_directory_uri() . '/assets');
}

/**
 * Return the path to the NPPL logo.
 *
 * @return string
 */
function proa_get_logo()
{
    $logo = proa_get_asset_path() . '/img/NPPL-logo-White.svg';

    return $logo;
}

/**
 * Takes a text and a limit and returns the text up to the maximum character length (limit).
 *
 * @param string $text
 * @param integer $limit
 *
 * @return string
 */
function proa_limit_text($text, $limit = 50)
{
    return ( strlen($text) < $limit ) ? $text : substr($text, 0, $limit) . '...';
}

/**
 * Returns the label for a given post according to defined logic. Returns 'nieuws' if there are no matches
 * on the other rules.
 *
 * @param WP_Post $post The WordPress post to retrieve the label for.
 *
 * @return string
 */
function proa_get_post_label(WP_Post $post)
{
    if (has_category('video', $post)) {
        $taxonomy = 'Video';
    }

    if (has_category('algemeen', $post)) {
        $taxonomy = 'Nieuws';
    }

    if (get_field('expert', $post)) {
        $taxonomy = get_the_title(get_field('expert', $post));
    }

    if (get_field('participant', $post)) {
        $taxonomy = get_the_title(get_field('participant', $post));
    }

    if (get_field('author', $post)) {
        $taxonomy = get_the_title(get_field('author', $post));
    }

    return $taxonomy ?? 'Nieuws';
}

/**
 * @param bool $is_site_nav
 */
function proa_nav($is_site_nav = true)
{
    wp_nav_menu(
        [
            'theme_location'  => 'header-menu',
            'menu'            => '',
            'container'       => 'div',
            'container_class' => 'c-menu-container--{menu slug}',
            'container_id'    => '',
            'menu_class'      => 'c-menu',
            'menu_id'         => '',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'before'          => '',
            'after'           => '',
            'link_before'     => '',
            'link_after'      => '',
            'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
            // 'items_wrap'      => proa_nav_wrap( $is_site_nav ),
            'depth'           => 0,
            'walker'          => '',
        ]
    );
}

/**
 * Returns a formatted href link to the page of the author of the post.
 *
 * @param WP_Post $post
 *
 * @return string
 */
function proa_get_the_author(WP_Post $post)
{
    $defined_author = get_field('author', $post->ID);

    if (! $defined_author) {
        return sprintf('<a href="%s">%s</a>', '/over-nppl/', 'NPPL');
    }

    return sprintf('<a href="%s">%s</a>', get_permalink($defined_author), get_the_title($defined_author));
}


/**
 * Renders the pagination buttons for the site.
 *
 * @param WP_Query $query The WordPress query to use with pagination.
 * @param bool $echo Whether to echo the result or not.
 *
 * @return array|string|void
 */
function proa_pagination(WP_Query $query, bool $echo = false)
{
    $big        = 999999999;
    $paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    $pagination = paginate_links([
        'base'               => str_replace($big, '%#%', get_pagenum_link($big)),
        'format'             => '?paged=%#%',
        'current'            => max(1, $paged),
        'total'              => $query->max_num_pages,
        'paged'              => $paged,
        'end_size'           => 1,
        'mid_size'           => 2,
        'prev_text'          => sprintf(
            '%s <span class="u-extra">%s</span>',
            __('« Vorige', 'tclievelde'),
            __("pagina", 'tclievelde')
        ),
        'next_text'          => sprintf(
            '%s <span class="u-extra">%s</span> »',
            __('Volgende', 'tclievelde'),
            __("pagina", 'tclievelde')
        ),
        'before_page_number' => '<span class="u-extra">' . __('', 'tclievelde') . '</span> ',
    ]);

    if (! $echo) {
        return $pagination;
    }

    echo $pagination;
}

/**
 * Alters the maximum amount of posts per archive page. The default is 10, but 9 works better with our
 * layout (rows of 3).
 *
 * @param WP_Query $query
 */
function proa_change_posts_per_page(WP_Query $query)
{
    if ($query->is_archive() && $query->is_main_query() && ! is_admin()) {
        $query->set('posts_per_page', 9);
    }
}

/**
 * Returns a proxy url from the given image URL.
 *
 * @param string $imageURL URL from within our domain. This function will not work with other domain names other
 *                             than itself (WP_HOME).
 * @param int|null $width force the width of the image returned by the proxy.
 * @param int|null $height force the height of the image returned by the proxy.
 * @param boolean $formatAuto Choose to automatically select the image format. (E.g. WebP for modern browsers).
 *
 * @return string             URL to the image from the proxy.
 */
function proa_get_proxy_to_image(
    $imageURL,
    ?int $width = null,
    ?int $height = null,
    bool $formatAuto = false
): string {
    if (! is_string($imageURL)) {
        return $imageURL;
    }

    $imageURL = str_replace(
        WP_HOME,
        sprintf('https://%s', FRV_IMAGE_PROXY_HOST),
        $imageURL
    );

    $params = [];

    if ($width) {
        $params['w'] = $width;
    }

    if ($height) {
        $params['h'] = $height;
    }

    if ($formatAuto) {
        $params['auto'] = 'format';
    }

    if (empty($params)) {
        return $imageURL;
    } else {
        return $imageURL . '?' . http_build_query($params);
    }
}

/**
 * Returns a proxy url from the given Post's thumbnail image.
 *
 * @param WP_Post $post URL from within our domain. This function will not work with other domain names other than
 *                         itself (WP_HOME).
 * @param int|null $width force the width of the image returned by the proxy.
 * @param int|null $height force the height of the image returned by the proxy.
 *
 * @return string           URL to the image from the proxy.
 */
function proa_get_proxy_to_thumbnail_url(WP_Post $post, ?int $width = null, ?int $height = null)
{
    return proa_get_proxy_to_image(get_the_post_thumbnail_url($post->ID), $width, $height);
}

/**
 * Generates and returns a post image with given HTML image width and image source width.
 * The image data is taken from the proxy and includes the alt text, taken from the post_meta.
 *
 * @param int $postThumbnailID
 * @param int|null $domWidth width of HTML Image node.
 * @param int|null $imgWidth = $domWidth if null given.
 * @param string|null $extraClasses
 *
 * @return string               HTML Image node.
 */
function proa_generate_post_img_with_proxy(int $postThumbnailID, int $domWidth = null, int $imgWidth = null, string $extraClasses = null)
{
    $imgWidth = $imgWidth ?: $domWidth;

    return '<img
        width="' . $domWidth . '"
        src="' . proa_get_proxy_to_image(wp_get_attachment_url($postThumbnailID), $imgWidth) . '"
        class="attachment-wide size-wide wp-post-image ' . $extraClasses . '"
        alt="' . ( array_key_exists(
            '_wp_attachment_image_alt',
            get_post_meta($postThumbnailID)
        ) ? get_post_meta($postThumbnailID)['_wp_attachment_image_alt']['0'] : '' ) .
           '">';
}

add_action('pre_get_posts', 'proa_change_posts_per_page');
