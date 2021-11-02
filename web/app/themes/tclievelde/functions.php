<?php

require_once __DIR__ . '/functions/menu.php';
require_once __DIR__ . '/template_parts/hero-article.php';

use Tclievelde\Tclievelde;

function tclievelde_enqueue_scripts()
{
    $mainCssPath  = '%s/assets/css/index.css';
    $mainJsPath   = '%s/assets/js/index.js';
    $globalJsPath = '%s/assets/js/bundles/global.bundle.js';

    wp_enqueue_style(
        'main-css',
        sprintf($mainCssPath, get_template_directory_uri()),
        null,
        tclievelde_get_version(sprintf($mainCssPath, get_stylesheet_directory()))
    );

    wp_enqueue_script(
        'main-js',
        sprintf($mainJsPath, get_template_directory_uri()),
        null,
        tclievelde_get_version(sprintf($mainJsPath, get_template_directory())),
        true
    );

    wp_enqueue_script(
        'global-js',
        sprintf(
            $globalJsPath,
            get_template_directory_uri()
        ),
        null,
        tclievelde_get_version(sprintf($mainJsPath, get_template_directory())),
        true
    );
    wp_enqueue_script('news', sprintf('%s/assets/js/bundles/news.bundle.js', get_template_directory_uri()), null, '0.0.1', true);
    if (get_post_type() === 'page' && get_page_uri() === 'wedstrijden') {
        wp_enqueue_script('activeplayers', sprintf('%s/assets/js/bundles/activeplayers.bundle.js', get_template_directory_uri()), null, '0.0.1', true);
    }
    if (get_post_type() === 'page' && get_page_uri() === 'leden') {
        wp_enqueue_script('uploads', sprintf('%s/assets/js/bundles/uploads.bundle.js', get_template_directory_uri()), null, '0.0.1', true);
    }
    if (get_post_type() === 'page' && get_page_uri() === 'competitie') {
        wp_enqueue_script('competition', sprintf('%s/assets/js/bundles/competition.bundle.js', get_template_directory_uri()), null, '0.0.1', true);
    }
}
/**
 * Get a unique version number based on the timestamp when the file was last updated.
 *
 * @param string $fileLocation
 *
 * @return string
 */
function tclievelde_get_version(string $fileLocation): string
{
    if (file_exists($fileLocation)) {
        return substr(md5(filemtime($fileLocation)), 0, 6);
    }

    return 'no-version';
}

add_action('wp_enqueue_scripts', 'tclievelde_enqueue_scripts');

flush_rewrite_rules(false);
