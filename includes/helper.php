<?php
/**
 * Helper
 *
 * @package     EAL\Helper
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Public assets folder
 */
function eal_the_assets() {
    echo EAL_URL . 'public';
}

/*
 * Better debugging
 */
function eal_debug( $args, $title = false ) {

    if ( $title ) {
        echo '<h3>' . $title . '</h3>';
    }

    if ( $args ) {
        echo '<pre>';
        print_r($args);
        echo '</pre>';
    }
}

