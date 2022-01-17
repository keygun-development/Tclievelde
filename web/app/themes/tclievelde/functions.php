<?php

require_once __DIR__ . '/functions/menu.php';
require_once __DIR__ . '/template_parts/hero-article.php';

/** Proa tech bubble row shortcode */
require_once __DIR__ . '/functions/detail-bubbles.php';

/** Alter the behaviour of the comments field. */
require_once __DIR__ . '/functions/comment-form-fields.php';

/** Custom comment callback to render the comments with our own markup. */
require_once __DIR__ . '/functions/custom-comment-callback.php';

require_once __DIR__ . '/functions/api/class-proa-api-response-factory.php';
require_once __DIR__ . '/functions/api/class-proa-api-serializer.php';
require_once __DIR__ . '/functions/api/class-proa-api-suggestion-serializer.php';
require_once __DIR__ . '/functions/api/class-proa-api-response-document.php';
require_once __DIR__ . '/functions/api/class-proa-searcher.php';
require_once __DIR__ . '/functions/api/class-proa-suggestion-searcher.php';

/** Base Proa_Object which other Proa_* objects can extends. */
require_once __DIR__ . '/functions/core/class-proa-base-properties.php';
require_once __DIR__ . '/functions/core/class-proa-retrievable-object.php';
require_once __DIR__ . '/functions/core/class-proa-object.php';
require_once __DIR__ . '/functions/core/class-proa-post-abstract.php';
require_once __DIR__ . '/functions/core/class-proa-term-abstract.php';

/** Custom post types */
require_once __DIR__ . '/functions/custom-post-types/reservation.php';

require_once __DIR__ . '/functions/custom-post-types/class-proa-post.php';
require_once __DIR__ . '/functions/custom-post-types/class-proa-reservation.php';

require_once __DIR__ . '/functions/custom-users/users.php';

/** Defines custom image sizes for the theme. */
require_once __DIR__ . '/functions/image-sizes.php';

/** Removes several actions from WordPress. */
require_once __DIR__ . '/functions/remove-actions.php';

/** Loads required class and conditional logic for the site hero. */
require_once __DIR__ . '/functions/site-hero-logic.php';

/** Loads the get SVG function. */
require_once __DIR__ . '/functions/get-svg-icon.php';

/** Includes various helper functions, such as dd(), dump() and things like proa_get_logo(). */
require_once __DIR__ . '/functions/helpers.php';

/** Includes all the required "general" shortcodes. */
require_once __DIR__ . '/functions/shortcodes.php';

/** Includes the required shortcodes for expert/participant/technique overviews. */
require_once __DIR__ . '/functions/custom-post-type-shortcodes.php';

/** Registers our custom sidebars with WordPress. */
require_once __DIR__ . '/functions/register-sidebars.php';

/** Excerpts */
require_once __DIR__ . '/functions/excerpt.php';

/** Registers filters */
require_once __DIR__ . '/functions/filters.php';

require_once __DIR__.'/functions/query-transform/QueryTransformRegistry.php';
QueryTransformRegistry::registerAll();

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
    if (get_post_type() === 'page' && get_page_uri() === 'leden') {
        wp_enqueue_script('uploads', sprintf('%s/assets/js/bundles/uploads.bundle.js', get_template_directory_uri()), null, '0.0.1', true);
    }
    if (get_post_type() === 'page' && get_page_uri() === 'competitie') {
        wp_enqueue_script('competition', sprintf('%s/assets/js/bundles/competition.bundle.js', get_template_directory_uri()), null, '0.0.1', true);
    }
    if (get_page_uri() === 'actueel') {
        wp_enqueue_script('news', sprintf('%s/assets/js/bundles/news.bundle.js', get_template_directory_uri()), null, '0.0.1', true);
    }
    if (get_page_uri() === 'reserveren' || get_page_uri() === 'reservering') {
        wp_enqueue_script('activeplayers', sprintf('%s/assets/js/bundles/activeplayers.bundle.js', get_template_directory_uri()), null, '0.0.1', true);
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

/**
 * @param $lidn1
 * @param $lidn2
 * @param $lidn3
 * @param $lidnummer
 * @param $m11
 * @param $m12
 * @param $m13
 * @param $m21
 * @param $m22
 * @param $m23
 * @param $m31
 * @param $m32
 * @param $m33
 * @param $medespeler1
 * @param $medespeler2
 * @param $medespeler3
 * @param $allreserveringlidnummers
 * @param $thisreservation
 */
function checkPlayerAvailability($lidn1, $lidn2, $lidn3, $lidnummer, $m11, $m12, $m13, $m21, $m22, $m23, $m31, $m32, $m33, $medespeler1, $medespeler2, $medespeler3, $allreserveringlidnummers, $thisreservation): string
{
    while ($reserveringlidnummers = $allreserveringlidnummers->fetch_assoc()) {
        // Check medespelers
        if ($lidnummer !== 0) {
            if ($lidn1->num_rows > 1 || $lidn2->num_rows > 1 || $lidn3->num_rows > 1) {
                dd('test');
                return $lidnummer . ' heeft al een reservering in het systeem staan.';
            }
        }
        if ($m11->num_rows > 0) {
            while ($mede11 = $m11->fetch_assoc()) {
                if ($thisreservation) {
                    if ($mede11['Medespeler1'] && $mede11['Id'] !== $thisreservation['Id']) {
                        return $medespeler1 . ' heeft al een reservering in het systeem staan.';
                    }
                } else {
                    if ($mede11['Medespeler1']) {
                        return $medespeler1 . ' heeft al een reservering in het systeem staan.';
                    }
                }
            }
        }
        if ($m12->num_rows > 0) {
            while ($mede12 = $m12->fetch_assoc()) {
                if ($thisreservation) {
                    if ($mede12['Medespeler1'] && $mede12['Id'] !== $thisreservation['Id']) {
                        return $medespeler2 . ' heeft al een reservering in het systeem staan.';
                    }
                } else {
                    if ($mede12['Medespeler1']) {
                        return $medespeler2 . ' heeft al een reservering in het systeem staan.';
                    }
                }
            }
        }
        if ($m13->num_rows > 0) {
            while ($mede13 = $m13->fetch_assoc()) {
                if ($thisreservation) {
                    if ($mede13['Medespeler1'] && $mede13['Id'] !== $thisreservation['Id']) {
                        return $medespeler3 . ' heeft al een reservering in het systeem staan.';
                    }
                } else {
                    if ($mede13['Medespeler1']) {
                        return $medespeler3 . ' heeft al een reservering in het systeem staan.';
                    }
                }
            }
        }
        if ($m21->num_rows > 0) {
            if ($m21->fetch_assoc()['Medespeler2'] === $reserveringlidnummers['Lidnummer']) {
                return $medespeler1 . ' heeft al een reservering in het systeem staan.';
            }
        }
        if ($m22->num_rows > 0) {
            if ($m22->fetch_assoc()['Medespeler2'] === $reserveringlidnummers['Lidnummer']) {
                if ($medespeler2 !== 0) {
                    return $medespeler2 . ' heeft al een reservering in het systeem staan.';
                }
            }
        }
        if ($m23->num_rows > 0) {
            if ($m23->fetch_assoc()['Medespeler2'] === $reserveringlidnummers['Lidnummer']) {
                if ($medespeler3 !== 0) {
                    return $medespeler3 . ' heeft al een reservering in het systeem staan.';
                }
            }
        }
        if ($m31->num_rows > 0) {
            if ($m31->fetch_assoc()['Medespeler3'] === $reserveringlidnummers['Lidnummer']) {
                return $medespeler1 . ' heeft al een reservering in het systeem staan.';
            }
        }
        if ($m32->num_rows > 0) {
            if ($m32->fetch_assoc()['Medespeler3'] === $reserveringlidnummers['Lidnummer']) {
                return $medespeler2 . ' heeft al een reservering in het systeem staan.';
            }
        }
        if ($m33->num_rows > 0) {
            if ($m33->fetch_assoc()['Medespeler3'] === $reserveringlidnummers['Lidnummer']) {
                if ($medespeler3 !== 0) {
                    return $medespeler3 . ' heeft al een reservering in het systeem staan.';
                }
            }
        }

        // Check lidnummers
        if ($medespeler1 === $reserveringlidnummers['Lidnummer']) {
            return $medespeler1." heeft al een reservering in het systeem staan.";
        }
        if ($medespeler2 === $reserveringlidnummers['Lidnummer']) {
            return $medespeler2." heeft al een reservering in het systeem staan.";
        }
        if ($medespeler3 === $reserveringlidnummers['Lidnummer']) {
            return $medespeler3." heeft al een reservering in het systeem staan.";
        }
    }
    return false;
}

/** ACF Custom Blocks */
function register_acf_block_types()
{
    acf_register_block_type([
        'name'            => 'block-techniques',
        'title'           => __('Technieken'),
        'description'     => __('Toont een lijst met geselecteerde technieken.'),
        'render_template' => 'template-parts/blocks/techniques/techniques.php',
        'category'        => 'widgets',
        'icon'            => 'editor-ul',
        'keywords'        => ['technieken', 'techniques'],
    ]);
}

/** Check if function exists and hook into setup. */
if (function_exists('acf_register_block_type')) {
    add_action('acf/init', 'register_acf_block_types');
}