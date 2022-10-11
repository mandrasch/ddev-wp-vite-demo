<?php


$composer_autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
}

use Idleberg\WordpressViteAssets\WordpressViteAssets;



/**
 * Child theme stylesheet einbinden in Abhängigkeit vom Original-Stylesheet
 */
function child_theme_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

    // Check if dev or production mode
    // TODO: what is the best way to figure this out?


    if (file_exists(__DIR__ . '/dist/manifest.json')) {
        // ===== PRODUCTION ======
        // https://github.com/idleberg/php-wordpress-vite-assets
        $baseUrl = get_stylesheet_directory();
        $manifest = "dist/manifest.json";
        $entryPoint = "src/js/main.js";

        $viteAssets = new WordpressViteAssets($manifest, $baseUrl);
        $viteAssets->addAction($entryPoint);
    } else {
        // ===== DEVELOPMENT ======
        // thx to https://github.com/fgeierst/typo3-vite-demo/blob/master/packages/typo3_vite_demo/Configuration/TypoScript/setup.typoscript#L167

        wp_enqueue_script('vite-dev-client', site_url() . ":5173/@vite/client", array(), '1.0.0', false);

        wp_enqueue_script('vite-dev-app-js', site_url() . ":5173/src/js/app.js", array(), '1.0.0', false);
    }


    /* Vite\enqueue_asset(
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
      );*/
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
