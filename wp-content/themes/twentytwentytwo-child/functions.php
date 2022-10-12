<?php


$composer_autoload = dirname(__DIR__) . '/twentytwentytwo-child/vendor/autoload.php';
if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
}

use Idleberg\WordpressViteAssets\WordpressViteAssets;

// TODO: bundle this somehow in function?

// ===== PRODUCTION ======
// https://github.com/idleberg/php-wordpress-vite-assets

// TODO: What is the best way to set an environment var in standard WP?
// Set define('WP_ENV', 'development') or define('WP_ENV', 'production') in wp-config.php
if (!defined('WP_ENV') || WP_ENV === 'production') {

    // ===== PRODUCTION ======
    // https://github.com/idleberg/php-wordpress-vite-assets
    $baseUrl = get_stylesheet_directory_uri() . "/dist/";
    $manifest = __DIR__ . "/dist/manifest.json";
    $entryPoint = "src/js/app.js";

    $viteAssets = new WordpressViteAssets($manifest, $baseUrl);
    $viteAssets->addAction($entryPoint); // TODO: use array with css?
}


function child_theme_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Include dev client server script (if no manifest.json is found)
    if (defined('WP_ENV') && WP_ENV === 'development') {
        // ===== DEVELOPMENT ======
        // thx to https://github.com/fgeierst/typo3-vite-demo/blob/master/packages/typo3_vite_demo/Configuration/TypoScript/setup.typoscript#L167

        wp_enqueue_script('vite-dev-client', site_url() . ":5173/@vite/client", array(), '1.0.0', false);
        wp_enqueue_script('vite-dev-app-js', site_url() . ":5173/src/js/app.js", array(), '1.0.0', false);
    }
}
add_action('wp_enqueue_scripts', 'child_theme_styles');

// important: add type=module to vite client
// https://stackoverflow.com/a/59594789/809939
add_filter('script_loader_tag', 'add_type_attribute', 10, 3);
function add_type_attribute($tag, $handle, $src)
{
    // if not your script, do nothing and return original $tag
    if ('vite-dev-client' !== $handle && 'vite-dev-app-js' !== $handle) {
        return $tag;
    }
    // change the script tag by adding type="module" and return it.
    $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
    return $tag;
}
