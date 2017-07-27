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

function mythemeslug_buttons() {
    if ( ! current_user_can( 'edit_posts' ) && ! current_user_can( 'edit_pages' ) ) {
        return;
    }

    if ( get_user_option( 'rich_editing' ) !== 'true' ) {
        return;
    }

    add_filter( 'mce_external_plugins', 'mythemeslug_add_buttons' );
    add_filter( 'mce_buttons', 'mythemeslug_register_buttons' );
}
add_action( 'init', 'mythemeslug_buttons' );

function mythemeslug_add_buttons( $plugin_array ) {
    $plugin_array['columns'] = EAL_URL .'public/js/tinymce-buttons.js';
    return $plugin_array;
}

function mythemeslug_register_buttons( $buttons ) {
    array_push( $buttons, 'columns' );
    return $buttons;
}