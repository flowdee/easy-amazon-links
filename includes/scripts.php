<?php
/**
 * Scripts
 *
 * @package     EAL\Scripts
 * @since       1.0.0
 */

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Load admin scripts
 *
 * @since       1.0.0
 * @global      string $post_type The type of post that we are editing
 * @return      void
 */
function eal_admin_scripts( $hook ) {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ) ? '' : '.min';

    wp_enqueue_script( 'eal_admin_js', EAL_URL . 'public/js/admin' . $suffix . '.js', array( 'jquery' ), EAL_VER );
    wp_enqueue_style( 'eal_admin_css', EAL_URL . 'public/css/admin' . $suffix . '.css', false, EAL_VER );

    add_editor_style( EAL_URL . 'public/css/editor.css' );
}
add_action( 'admin_enqueue_scripts', 'eal_admin_scripts', 100 );

/**
 * Load frontend scripts
 *
 * @since       1.0.0
 * @return      void
 */
function eal_scripts( $hook ) {

    // Use minified libraries if SCRIPT_DEBUG is turned off
    $suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

    wp_enqueue_script( 'eal_scripts', EAL_URL . 'public/js/scripts' . $suffix . '.js', array( 'jquery' ), EAL_VER, true );
    wp_enqueue_style( 'eal_styles', EAL_URL . 'public/css/styles' . $suffix . '.css', false, EAL_VER );

}
add_action( 'wp_enqueue_scripts', 'eal_scripts' );
