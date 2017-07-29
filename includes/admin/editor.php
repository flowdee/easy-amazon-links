<?php
/**
 * Editor
 *
 * @package     EAL\Admin\Editor
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Source: https://www.gavick.com/blog/wordpress-tinymce-custom-buttons
 */

function eal_tinymce_buttons() {
    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
        return;
    }

    if ( get_user_option( 'rich_editing' ) !== 'true' ) {
        return;
    }

    add_filter( 'mce_external_plugins', 'eal_add_tinymce_buttons' );
    add_filter( 'mce_buttons', 'mythemeslug_register_buttons' );
}
add_action( 'init', 'eal_tinymce_buttons' );

function eal_add_tinymce_buttons( $plugin_array ) {
    $plugin_array['eal'] = EAL_URL .'public/js/tinymce-buttons.js';
    return $plugin_array;
}

function eal_register_tinymce_buttons( $buttons ) {
    array_push( $buttons, 'eal' );
    return $buttons;
}