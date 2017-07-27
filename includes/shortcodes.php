<?php
/**
 * Shortcodes
 *
 * @package     EAL\Shortcodes
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add shortcode
 *
 * @param $atts
 * @param string $content
 * @return string
 */
function eal_add_shortcode( $atts, $content = '' ) {

    if ( ! eal_is_active() )
        return $content;

    $options = eal_get_options();

    $link_text = ( ! empty( $atts['text'] ) ) ? $atts['text'] : $content;
    $link_title = ( ! empty( $atts['title'] ) ) ? $atts['title'] : $link_text;

    // Types
    $link_asin = ( ! empty( $atts['asin'] ) ) ? $atts['asin'] : false;
    $link_search = ( ! empty( $atts['search'] ) ) ? $atts['search'] : $link_text;

    if ( $link_asin ) {
        $link_url = eal_get_affiliate_url( array( 'asin' => $link_asin ) );
    } else {
        $link_url = eal_get_affiliate_url( array( 'search' => $link_search ) );
    }

    if ( ! empty( $link_url ) && ! empty( $link_title ) && ! empty( $link_text ) ) {

        $link_classes = 'eal-link';

        if ( ! empty( $options['link_icon'] ) )
            $link_classes .= ' eal-link--icon';

        $link = '<a class="' . esc_html( $link_classes ) . '" href="' . esc_url( $link_url ) . '" title="' . esc_html( $link_title ) . '" target="_blank" rel="nofollow"';

        if ( $link_asin )
            $link .= ' data-eal-asin="' . esc_html( $link_asin ) . '"';

        if ( $link_search )
            $link .= ' data-eal-search="' . esc_html( $link_search ) . '"';

        $link .= '>';

        $link .= $link_text;

        if ( ! empty( $options['link_icon'] ) ) {
            $link .= '<span class="eal-link__icon eal-link__icon--' . esc_html( $options['link_icon'] ) . '"></span>';
        }

        $link .= '</a>';

        return $link;
    }

    return $content;
}
add_shortcode( 'eal', 'eal_add_shortcode' );

