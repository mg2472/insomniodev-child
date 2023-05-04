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