<?php
/**
 * Settings
 *
 * Source: https://codex.wordpress.org/Settings_API
 *
 * @package     EAL\Settings
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

if (!class_exists('Easy_Amazon_Links_Settings')) {

    class Easy_Amazon_Links_Settings
    {
        public $options;

        public function __construct()
        {
            // Options
            $this->options = get_option('eal_settings');

            // Initialize
            add_action('admin_menu', array( &$this, 'add_admin_menu') );
            add_action('admin_init', array( &$this, 'init_settings') );
        }

        function add_admin_menu()
        {
            /*
             * Source: https://codex.wordpress.org/Function_Reference/add_options_page
             */
            add_options_page(
                'Easy Amazon Links', // Page title
                'Easy Amazon Links', // Menu title
                'manage_options', // Capabilities
                EAL_SETTINGS_PAGE_SLUG, // Menu slug
                array( &$this, 'options_page' ) // Callback
            );

        }

        function init_settings()
        {

            register_setting(
                'eal_settings',
                'eal_settings',
                array( &$this, 'validate_input_callback' )
            );

            // Section: Quickstart
            add_settings_section(
                'eal_settings_section_quickstart',
                __('Quickstart Guide', 'affiliate-coupons'),
                array( &$this, 'section_quickstart_render' ),
                'eal_settings'
            );

            // Section: Amazon Tracking IDs
            add_settings_section(
                'eal_section_amazon_tracking_ids',
                __('Amazon Tracking IDs', 'easy-amazon-links'),
                false,
                'eal_settings'
            );

            $amazon_stores = eal_get_amazon_stores();

            foreach ( $amazon_stores as $store_key => $store_name ) {

                $store_flag = eal_get_icon_flag( $store_key );

                add_settings_field(
                    'eal_amazon_tracking_id_' . $store_key,
                    $store_flag . $store_name,
                    array( &$this, 'amazon_tracking_id_render' ),
                    'eal_settings',
                    'eal_section_amazon_tracking_ids',
                    array( 'store' => $store_key, 'label_for' => 'eal_amazon_tracking_id_' . $store_key )
                );
            }

            // Section: General
            add_settings_section(
                'eal_section_general',
                __('General Settings', 'easy-amazon-links'),
                array( &$this, 'section_qeneral_render' ),
                'eal_settings'
            );

            add_settings_field(
                'eal_amazon_store',
                __('Amazon Store', 'easy-amazon-links') . $req,
                array(&$this, 'amazon_store_render'),
                'eal_settings',
                'eal_section_general',
                array('label_for' => 'eal_amazon_store')
            );

        }

        function validate_input_callback( $input ) {

            /*
             * Here you can validate (and manipulate) the user input before saving to the database
             */

            return $input;
        }

        function section_quickstart_render() {
            ?>

            <div class="postbox">
                <h3 class='hndle'><?php _e('Quickstart Guide', 'affiliate-coupons'); ?></h3>
                <div class="inside">
                    <p>
                        <strong><?php _e( 'First Steps', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <ol>
                        <li><?php _e( 'Create vendors', 'affiliate-coupons' ); ?></li>
                        <li><?php _e( 'Create coupons', 'affiliate-coupons' ); ?></li>
                        <li><?php _e( 'Link coupons to vendors', 'affiliate-coupons' ); ?></li>
                        <li><?php _e( 'Assign categories and/or types to coupons if needed', 'affiliate-coupons' ); ?></li>
                        <li><?php _e( 'Display coupons inside your posts/pages by using shortcodes', 'affiliate-coupons' ); ?></li>
                    </ol>

                    <p>
                        <strong><?php _e( 'Show all coupons', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <p>
                        <code>[affcoups]</code>
                    </p>

                    <p>
                        <strong><?php _e( 'Show single coupons', 'affiliate-coupons' ); ?></strong>
                    </p>
                    <p>
                        <code>[affcoups id="123"]</code> <?php _e( 'or', 'affiliate-coupons' ); ?> <code>[affcoups id="123,456,789"]</code>
                    </p>

                    <?php do_action( 'eal_settings_quickstart_render' ); ?>
                </div>
            </div>

            <?php
        }

        function amazon_tracking_id_render( $args = array() ) {

            if ( empty( $args['store'] ) )
                return;

            $associates_links = eal_get_amazon_associates_links();

            $tracking_id = ( ! empty( $this->options['amazon_tracking_ids'][$args['store']] ) ) ? esc_attr( trim( $this->options['amazon_tracking_ids'][$args['store']] ) ) : '';

            ?>
            <input type="text"
                   data-eal-amazon-tracking-id-input="<?php echo $args['store']; ?>"
                   id="eal_amazon_tracking_id_<?php echo $args['store']; ?>"
                   name="eal_settings[amazon_tracking_ids][<?php echo $args['store']; ?>]"
                   value="<?php echo esc_attr( trim( $tracking_id ) ); ?>" />
            &nbsp;
            <small><a href="<?php echo $associates_links[$args['store']]; ?>" target="_blank" rel="nofollow"><?php _e('Get local Tracking ID', 'easy-amazon-links'); ?></a></small>
            <?php
        }

        function section_qeneral_render() {

            ?>

            <?php
        }

        function amazon_store_render() {

            $stores = eal_get_amazon_stores();

            $store = ( isset ( $this->options['amazon_store'] ) ) ? $this->options['amazon_store'] : '0';

            ?>
            <select id="eal_amazon_store" name="eal_settings[amazon_store]" data-eal-select-amazon-store="true" required="required">
                <option value=""><?php _e('Please select...', 'easy-amazon-links' ); ?></option>
                <?php foreach ( $stores as $store_key => $store_label ) { ?>
                    <?php
                    $store_selected = false;
                    $store_disabled = false;

                    $store_tracking_id = ( ! empty( $this->options['amazon_tracking_ids'][$store_key] ) ) ? true : false;

                    if ( $store_key === $store && $store_tracking_id )
                        $store_selected = true;

                    if ( ! $store_tracking_id )
                        $store_disabled = true;
                    ?>

                    <option value="<?php echo $store_key; ?>" <?php selected( $store_selected, true ); ?><?php disabled( $store_disabled, true ); ?> data-eal-select-amazon-store-option="<?php echo $store_key; ?>"><?php echo $store_label; ?></option>
                <?php } ?>
            </select>
            <p class="description<?php if ( empty( $store ) ) echo ' eal-req'; ?>">
                <?php _e('Please select your default Amazon store.', 'easy-amazon-links' ); ?>
            </p>
            <?php
        }


        function text_field_01_render() {

            $text = ( ! empty($this->options['text_01'] ) ) ? esc_attr( trim($this->options['text_01'] ) ) : ''

            ?>
            <input type="text" name="eal_settings[text_01]" id="eal_text_field_01" value="<?php echo esc_attr( trim( $text ) ); ?>" />
            <?php
        }

        function select_field_01_render() {

            $select_options = array(
                '0' => __('Please select...', 'easy-amazon-links'),
                '1' => __('Option One', 'easy-amazon-links'),
                '2' => __('Option Two', 'easy-amazon-links'),
                '3' => __('Option Three', 'easy-amazon-links')
            );

            $selected = ( isset ( $this->options['select_01'] ) ) ? $this->options['select_01'] : '0';

            ?>
            <select id="eal_select_field_01" name="eal_settings[select_01]">
                <?php foreach ( $select_options as $key => $label ) { ?>
                    <option value="<?php echo $key; ?>" <?php selected( $selected, $key ); ?>><?php echo $label; ?></option>
                <?php } ?>
            </select>
            <?php
        }

        function checkbox_field_01_render() { 

            $checked = ( isset ( $this->options['checkbox_01'] ) && $this->options['checkbox_01'] == '1' ) ? 1 : 0;
            ?>

                <input type="checkbox" id="eal_checkbox_field_01" name="eal_settings[checkbox_01]" value="1" <?php echo($checked == 1 ? 'checked' : ''); ?> />
                <label for="eal_checkbox_field_01"><?php _e('Activate in order to do some cool stuff.', 'easy-amazon-links'); ?></label>
            <?php
        }

        function text_field_02_render() {

            $text = ( ! empty($this->options['text_02'] ) ) ? esc_attr( trim($this->options['text_02'] ) ) : ''

            ?>
            <input type="text" name="eal_settings[text_02]" id="eal_text_field_02" value="<?php echo esc_attr( trim( $text ) ); ?>" />
            <?php
        }

        function options_page() {

            ?>

            <div class="eal eal-settings">
                <div class="wrap">
                    <h2><?php _e('Easy Amazon Links', 'easy-amazon-links'); ?></h2>

                    <div id="poststuff">
                        <div id="post-body" class="metabox-holder columns-2">
                            <div id="post-body-content">
                                <div class="meta-box-sortables ui-sortable">
                                    <form action="options.php" method="post">
                                        <?php
                                        settings_fields('eal_settings');
                                        eal_do_settings_sections('eal_settings');
                                        ?>

                                        <p><?php submit_button('Save Changes', 'button-primary', 'submit', false); ?></p>
                                    </form>
                                </div>

                            </div>
                            <!-- /#post-body-content -->
                            <div id="postbox-container-1" class="postbox-container">
                                <div class="meta-box-sortables">
                                    <?php
                                    /*
                                     * require_once WP_UDEMY_DIR . 'includes/libs/flowdee_infobox.php';
                                    $flowdee_infobox = new Flowdee_Infobox();
                                    $flowdee_infobox->set_plugin_slug('udemy');
                                    $flowdee_infobox->display();
                                    */
                                    ?>
                                </div>
                                <!-- /.meta-box-sortables -->
                            </div>
                            <!-- /.postbox-container -->
                        </div>
                    </div>
                </div>
            </div>
            
            <?php
        }
    }
}

new Easy_Amazon_Links_Settings();
/**
 * Custom settings section output
 * 
 * Replacing: do_settings_sections('eal_settings');
 * 
 * @param $page
 */
function eal_do_settings_sections( $page ) {

    global $wp_settings_sections, $wp_settings_fields;

    if (!isset($wp_settings_sections[$page]))
        return;

    foreach ((array)$wp_settings_sections[$page] as $section) {

        $title = '';

        if ($section['title'])
            $title = "<h3 class='hndle'>{$section['title']}</h3>\n";

        if ($section['callback'])
            call_user_func($section['callback'], $section);

        if (!isset($wp_settings_fields) || !isset($wp_settings_fields[$page]) || !isset($wp_settings_fields[$page][$section['id']]))
            continue;

        echo '<div class="postbox">';
        echo $title;
        echo '<div class="inside">';
        echo '<table class="form-table">';
        do_settings_fields($page, $section['id']);
        echo '</table>';
        echo '</div>';
        echo '</div>';
    }
}