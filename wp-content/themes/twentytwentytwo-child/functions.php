<?php


// we require it instead of composer because we forked
require_once 'vite-for-wp-modified.php';

use Kucrut\Vite;

/**
 * Child theme stylesheet einbinden in Abhängigkeit vom Original-Stylesheet
 */
function child_theme_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    
    Vite\enqueue_asset(
        __DIR__ . '/js/dist',
        'js/src/app.js',
        [
          'handle' => 'my-script-handle',
          //'dependencies' => ['wp-components', 'some-registered-script-handle'], // Optional script dependencies. Defaults to empty array.
          //'css-dependencies' => ['wp-components', 'some-registered-style-handle'], // Optional style dependencies. Defaults to empty array.
          //'css-media' => 'all', // Optional.
          //'css-only' => false, // Optional. Set to true to only load style assets in production mode.
          // 'in-footer' => true, // Optional. Defaults to false.
        ]
      );
}
add_action('wp_enqueue_scripts', 'child_theme_styles');
