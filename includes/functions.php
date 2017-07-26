<?php
/**
 * Functions
 *
 * @package     EAL\Functions
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get options
 *
 * return array options or empty when not available
 */
function eal_get_options() {
    return get_option( 'eal_settings', array() );
}

/**
 * Check if plugin status is active
 *
 * @return bool
 */
function eal_is_active() {

    $options = eal_get_options();

    return ( isset( $options['status'] ) && '1' == $options['status'] ) ? true : false;
}

/**
 * Amazon Stores
 */
function eal_get_amazon_stores() {

    $stores = array(
        'com.br' => __( 'Brazil', 'easy-amazon-links' ),
        'ca'     => __( 'Canada', 'easy-amazon-links' ),
        'cn'     => __( 'China', 'easy-amazon-links' ),
        'de'     => __( 'Germany', 'easy-amazon-links' ),
        'es'     => __( 'Spain', 'easy-amazon-links' ),
        'fr'     => __( 'France', 'easy-amazon-links' ),
        'in'     => __( 'India', 'easy-amazon-links' ),
        'it'     => __( 'Italy', 'easy-amazon-links' ),
        'co.jp'  => __( 'Japan', 'easy-amazon-links' ),
        'com.mx' => __( 'Mexico', 'easy-amazon-links' ),
        'co.uk'  => __( 'UK', 'easy-amazon-links' ),
        'com'    => __( 'US', 'easy-amazon-links' ),
        //'com.au' => __( 'Australia', 'easy-amazon-links' )
    );

    return $stores;
}

/**
 * Amazon Associates Links
 */
function eal_get_amazon_associates_links() {

    $associate_links = array(
        'de' => 'https://partnernet.amazon.de/',
        'com' => 'https://affiliate-program.amazon.com/',
        'co.uk' => 'https://affiliate-program.amazon.co.uk/',
        'ca' => 'https://associates.amazon.ca/',
        'fr' => 'https://partenaires.amazon.fr/',
        'co.jp' => 'https://affiliate.amazon.co.jp/',
        'it' => 'https://programma-affiliazione.amazon.it/',
        'cn' => 'https://associates.amazon.cn/',
        'es' => 'https://afiliados.amazon.es/',
        'in' => 'https://affiliate-program.amazon.in/',
        'com.br' => 'https://associados.amazon.com.br/',
        'com.mx' => 'https://afiliados.amazon.com.mx/gp/associates/join/landing/main.html'
    );

    // Australia not yet added to associates program

    return $associate_links;
}

/**
 * Display icon flag html
 *
 * @param $store
 */
function eal_the_icon_flag( $store ) {

    $output = eal_get_icon_flag( $store );

    if ( ! empty( $output ) )
        echo $output;
}

/**
 * Get icon flag html
 *
 * @param $store
 * @return string
 */
function eal_get_icon_flag( $store ) {

    $store = str_replace( array( 'co.', 'com.', 'com' ), array( '', '', 'us' ), $store );

    return '<span class="eal-icon-flag eal-icon-flag--' . esc_html( $store ) . '"></span>';
}

/**
 * Example function which uses your settings
 */
function eal_my_first_function() {

    // Using the plugin option on any place
    $options = eal_get_options();

    if ( isset( $options['select_01'] ) ) {
        echo $options['select_01'];
    }
}