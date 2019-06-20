<?php

if (!defined('ABSPATH'))
    return;

/** Big gaping security hole, but does prevent use of the WordPress App */
add_filter('xmlrpc_enabled', '__return_false');

global $theme_package, $theme_meta;

$theme_package = json_decode(file_get_contents(__DIR__ . '/package.json'));
$theme_meta = wp_get_theme();

$template_uri =     rtrim(get_template_directory_uri(), '/');
$stylesheet_uri =   rtrim(get_stylesheet_directory_uri(), '/');
$stylesheet_dir =   rtrim(get_stylesheet_directory(), '/');

$define = [
    "THEME_VERSION"             => $theme_package->version,
    "THEME_DOMAIN"              => $theme_meta['domain'],
    "THEME_NAME"                => $theme_meta['template'],
    "THEME_URI"                 => $stylesheet_uri,
    "THEME_DIR"                 => $stylesheet_dir,
    "THEME_ASSETS_URI"          => $stylesheet_uri . '/dist/',
    "THEME_ASSETS_DIR"          => $stylesheet_dir . '/dist/',
    "SITE_URL"                  => str_replace("http://", "//", rtrim(get_bloginfo('url'), '/')),
    "THEME_ICONSET_URL"         => $stylesheet_uri . "/dist/images/icons.svg",
    "SESSION_NAME"              => $theme_meta['domain'],
    "MOBILE_SIZE"               => 575
];

foreach($define as $var => $value)
{
    if (!defined($var))
        define($var, $value);
}

require_once __DIR__."/_functions/ouw.php";

Oneupweb\autoload_folder(__DIR__ . "/_functions");
Oneupweb\autoload_folder(__DIR__ . "/_hooks");
Oneupweb\autoload_folder(__DIR__ . "/_post-types");
Oneupweb\autoload_folder(__DIR__ . "/_shortcodes");

add_action('wp_enqueue_scripts', function () use ($theme_package)
{
    if (is_admin())
        return;

    /** typecase comes with its own styles and scripts which are not enabled by default, this turns 'em on */
    wp_enqueue_style('typecase-styles');
    wp_enqueue_script('typecase-support');

    if (isset($theme_package->fonts) && is_array($theme_package->fonts)) {
        foreach($theme_package->fonts as $x => $font) {
            wp_enqueue_style("fontpack-$x", $font);
        }
    }

    wp_enqueue_style('theme', THEME_URI . '/style.css', array(), THEME_VERSION);    

    /** we don't need no bloated frameworks */
    wp_deregister_script("jquery");
    
});

add_action('wp', function () 
{

    /** some more useless bandwidth wasters */
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');    
    
});

add_action('after_setup_theme', function ()
{
    add_theme_support('post-thumbnails', apply_filters("Theme/thumbnail_post_types", 
        ['post', 'page']
    ));
    
    add_image_size('banner', 2000, 1000, true);
    add_image_size('super_large', 2000, 2000, false);
    add_image_size('large_square', 1000, 1000, true);
    add_image_size('medium_square', 750, 750, true);
    add_image_size('small_square', 360, 360, true);

    add_theme_support('post-formats', apply_filters("Theme/post_formats", 
        ['standard', 'video', 'gallery', 'image', 'link']
    ));

    add_theme_support('align-wide');
    add_theme_support('title-tag');

    add_theme_support('html5', apply_filters("Theme/html5_support", 
        ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']
    ));

    add_theme_support('custom-header');
    add_theme_support('custom-logo', apply_filters("Theme/custom_logo_args", [
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => [
            apply_filters("Theme/custom_logo_title", 'site-title'), 
            apply_filters("Theme/custom_logo_desc", 'site-desc')
        ]
    ]));

});

add_action('init', function ()
{
    
    register_nav_menus([
        'primary'       => 'Primary Navigation',
        'secondary'     => 'Secondary Navigation',
        'footer'        => 'Footer Navigation'
    ]);

    if (is_admin() || $GLOBALS['pagenow'] === 'wp-login.php') {
        return;
    }

    Oneupweb\enqueue_assets('script', [
        'js/polyfill-event.min.js',        
        'js/svg4everybody.min.js'
    ], false);

    Oneupweb\enqueue_assets("script", [
        "js/slideout.min.js",
        'js/aria-controller.min.js',
        'js/onscroll.min.js'
    ], true);
    
    Oneupweb\enqueue_assets("script", [
        "//platform.instagram.com/en_US/embeds.js"
    ]);

});

add_action( 'widgets_init', function () {

    register_sidebar( array(
        'name'          => 'Post sidebar',
        'id'            => 'post-sidebar',
        'before_widget' => '<aside class="widget">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>',
    ) );

} );

add_filter('widget_text', 'do_shortcode');

do_action('Theme/loaded');
