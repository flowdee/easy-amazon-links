<?php
/**
 * Hooks
 *
 * @package     EAL\Hooks
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function eal_filter_content( $content ) {

    //$content = str_replace('<span class="eal-link">', '<span class="eal-link" data-eal-link="true">', $content );
    $content = preg_replace('/<span data-eal-link="true">(.*?)<\/span>/', '[eal]$1[/eal]', $content );

    return $content;
}
add_filter( 'the_content', 'eal_filter_content' );
