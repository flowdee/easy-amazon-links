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

/**
 * Replacing TinyMCE button html with shortcode
 *
 * @param $content
 * @return mixed
 */
function eal_filter_content( $content ) {

    //$content = str_replace( '<span class="eal-link">', '<span class="eal-link" data-eal-link="true">', $content );
    $content = preg_replace( '/<span data-eal-link="true">(.*?)<\/span>/', '[eal]$1[/eal]', $content );

    return $content;
}
add_filter( 'the_content', 'eal_filter_content' );

/**
 * Maybe embed geotargeting script data
 */
function eal_embed_geotargeting_script_data() {

    $options = eal_get_options();

    if ( ! isset( $options['geotargeting'] ) || '1' != $options['geotargeting'] )
        return;

    $stores = eal_get_amazon_stores();

    // Settings
    if ( empty( $options['amazon_store'] ) )
        return;

    $settings = array( 'store' => $options['amazon_store'] );

    // Collect tracking IDs
    $tracking_ids = array();

    foreach ( $stores as $store_key => $store_label ) {

        if ( ! empty ( $options['amazon_tracking_ids'][$store_key] ) )
            $tracking_ids[$store_key] = $options['amazon_tracking_ids'][$store_key];
    }

    if ( 0 == sizeof( $tracking_ids ) )
        return;

    // Collect localized stores
    $localized_stores = array(
        // Defaults
        "br" => "com.br",
        "ca" => "ca",
        "cn" => "cn",
        "de" => "de",
        "es" => "es",
        "fr" => "fr",
        "in" => "in",
        "it" => "it",
        "jp" => "co.jp",
        "mx" => "com.mx",
        "gb" => "co.uk",
        "us" => "com",
        // Extended
        "at" => "de",
        "ch" => "de",
        "ie" => "co.uk"
    );

    ?>
    <script type="text/javascript">
        /* <![CDATA[ */
        var eal_geotargeting_settings = <?php echo json_encode( $settings ); ?>;
        var eal_geotargeting_localized_stores = <?php echo json_encode( $localized_stores ); ?>;
        var eal_geotargeting_tracking_ids = <?php echo json_encode( $tracking_ids ); ?>;
        /* ]]> */
    </script>
    <?php
}
add_action( 'wp_footer', 'eal_embed_geotargeting_script_data', 100 );
