<?php

if (!defined('ABSPATH')) exit; //Exit if accessed directly.

/**
 * Add child theme vars
 */
add_action('after_setup_theme', 'idtChildDefineVars', 1);
function idtChildDefineVars() 
{
    define('IDT_CHILD_THEME_DIR', get_stylesheet_directory_uri());
    define('IDT_CHILD_THEME_PATH', get_stylesheet_directory());
}

/**
 * Add child theme text domain
 */
add_action( 'after_setup_theme', 'idtChildAddTextDomain' );
function idtChildAddTextDomain() 
{
    load_child_theme_textdomain('insomniodev-child', IDT_CHILD_THEME_PATH . '/i18n/languages');
}

/**
 * Add child theme dependencies
 */
add_action('init' , 'idtChildIncludes', 1);
function idtChildIncludes()
{
    /**
     * Remove comments if you need to do fetch or async requests
     */
//    include_once IDT_CHILD_THEME_PATH . '/includes/classes/child_async_handler.php';
//
//    add_action('wp_ajax_idtRequestsRouter', 'IdtChildAsyncHandler::idtRequestsRouter');
//    add_action('wp_ajax_nopriv_idtRequestsRouter', 'IdtChildAsyncHandler::idtRequestsRouter');
}

/**
 * Add child theme custom post types and taxonomies
 */
add_action('init', 'idtChildRegisterPostsAndTaxs');
function idtChildRegisterPostsAndTaxs()
{
    include_once IDT_CHILD_THEME_PATH . '/includes/classes/child_taxonomies.php';
    $tax = new IdtChildTaxonomies();
    $tax->registerPostAndTax();
}

/**
 * Add child theme styles
 */
add_action('wp_enqueue_scripts', 'idtChildAddThemeStyles');
function idtChildAddThemeStyles()
{
    wp_register_style( 'idtChildThemeStyles', IDT_CHILD_THEME_DIR . '/assets/styles/css/child-master.css', ['idtThemeStyles'], '1.0.0');
    wp_enqueue_style( 'idtChildThemeStyles' );
}

//Include  ACF
// Define path and URL to the ACF plugin.
define('MY_ACF_PATH', get_stylesheet_directory() . '/includes/acf/');
define('MY_ACF_URL', get_stylesheet_directory_uri() . '/includes/acf/');
// Include the ACF plugin.
include_once(MY_ACF_PATH . 'acf.php');
// Customize the url setting to fix incorrect asset URLs.
add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url($url)
{
    return MY_ACF_URL;
}
// (Optional) Hide the ACF admin menu item.
add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin($show_admin)
{
    return true;
}