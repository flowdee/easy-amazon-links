<?php
/**
 * Settings
 *
 * @package     EAL\Admin\Plugins
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Plugins row action links
 *
 * @param array $links already defined action links
 * @param string $file plugin file path and name being processed
 * @return array $links
 */
function eal_action_links( $links, $file ) {

    $settings_link = '<a href="' . admin_url( 'options-general.php?page=' . EAL_SETTINGS_PAGE_SLUG ) . '">' . esc_html__( 'Settings', 'easy-amazon-links' ) . '</a>';

    if ( 'easy-amazon-links/easy-amazon-links.php' == $file )
        array_unshift( $links, $settings_link );

    return $links;
}
add_filter( 'plugin_action_links', 'eal_action_links', 10, 2 );

/**
 * Plugin row meta links
 *
 * @param array $input already defined meta links
 * @param string $file plugin file path and name being processed
 * @return array $input
 */
function eal_row_meta( $input, $file ) {

    if ( 'easy-amazon-links/easy-amazon-links.php' != $file )
        return $input;

    $custom_link = esc_url( add_query_arg( array(
            'utm_source'   => 'plugins-page',
            'utm_medium'   => 'plugin-row',
            'utm_campaign' => 'Easy Amazon Links',
        ), 'https://easy-amazon-links.com/' )
    );

    $links = array(
        '<a href="' . $custom_link . '">' . esc_html__( 'Example Link', 'easy-amazon-links' ) . '</a>',
    );

    $input = array_merge( $input, $links );

    return $input;
}
add_filter( 'plugin_row_meta', 'eal_row_meta', 10, 2 );
