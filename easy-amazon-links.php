<?php
/**
 * Plugin Name:     Easy Amazon Links
 * Plugin URI:      https://wordpress.org/plugins/easy-amazon-links/
 * Description:     Easily create text affiliate links for Amazon Associates
 * Version:         1.0.1
 * Author:          flowdee
 * Author URI:      https://coder.flowdee.de
 * Text Domain:     easy-amazon-links
 *
 * @package         EAL
 * @author          flowdee
 * @copyright       Copyright (c) flowdee
 *
 * Copyright (c) 2017 - flowdee ( https://twitter.com/flowdee )
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Easy_Amazon_Links' ) ) {

    /**
     * Main Easy_Amazon_Links class
     *
     * @since       1.0.0
     */
    class Easy_Amazon_Links {

        /**
         * @var         Easy_Amazon_Links $instance The one true Easy_Amazon_Links
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true Easy_Amazon_Links
         */
        public static function instance() {
            if ( ! self::$instance ) {
                self::$instance = new Easy_Amazon_Links();
                self::$instance->setup_constants();
                self::$instance->includes();
                self::$instance->load_textdomain();
            }

            return self::$instance;
        }


        /**
         * Setup plugin constants
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function setup_constants() {

            // Plugin name
            define( 'EAL_NAME', 'Easy Amazon Links' );

            // Plugin version
            define( 'EAL_VER', '1.0.1' );

            // Plugin path
            define( 'EAL_DIR', plugin_dir_path( __FILE__ ) );

            // Plugin URL
            define( 'EAL_URL', plugin_dir_url( __FILE__ ) );

            // Plugin Settings
            define ( 'EAL_SETTINGS_PAGE_SLUG', 'easy-amazon-links' );
        }
        
        /**
         * Include necessary files
         *
         * @access      private
         * @since       1.0.0
         * @return      void
         */
        private function includes() {

            // Basic
            require_once EAL_DIR . 'includes/helper.php';
            require_once EAL_DIR . 'includes/scripts.php';

            // Admin only
            if ( is_admin() ) {
                require_once EAL_DIR . 'includes/admin/plugins.php';
                require_once EAL_DIR . 'includes/admin/class.settings.php';
                require_once EAL_DIR . 'includes/admin/editor.php';
            }

            // Anything else
            require_once EAL_DIR . 'includes/functions.php';
            require_once EAL_DIR . 'includes/hooks.php';
            require_once EAL_DIR . 'includes/shortcodes.php';
        }

        /**
         * Internationalization
         *
         * @access      public
         * @since       1.0.0
         * @return      void
         */
        public function load_textdomain() {
            // Set filter for language directory
            $lang_dir = EAL_DIR . '/languages/';
            $lang_dir = apply_filters( 'eal_languages_directory', $lang_dir );

            // Traditional WordPress plugin locale filter
            $locale = apply_filters( 'plugin_locale', get_locale(), 'easy-amazon-links' );
            $mofile = sprintf( '%1$s-%2$s.mo', 'easy-amazon-links', $locale );

            // Setup paths to current locale file
            $mofile_local  = $lang_dir . $mofile;
            $mofile_global = WP_LANG_DIR . '/easy-amazon-links/' . $mofile;

            if ( file_exists( $mofile_global ) ) {
                // Look in global /wp-content/languages/easy-amazon-links/ folder
                load_textdomain( 'easy-amazon-links', $mofile_global );
            } elseif ( file_exists( $mofile_local ) ) {
                // Look in local /wp-content/plugins/easy-amazon-links/languages/ folder
                load_textdomain( 'easy-amazon-links', $mofile_local );
            } else {
                // Load the default language files
                load_plugin_textdomain( 'easy-amazon-links', false, $lang_dir );
            }
        }
    }
} // End if class_exists check

/**
 * The main function responsible for returning the one true Easy_Amazon_Links
 * instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \Easy_Amazon_Links The one true Easy_Amazon_Links
 *
 */
function eal_load() {
    return Easy_Amazon_Links::instance();
}
add_action( 'plugins_loaded', 'eal_load' );

/**
 * The activation hook
 */
function eal_activation() {
    // Create your tables here
}
register_activation_hook( __FILE__, 'eal_activation' );

/**
 * The deactivation hook
 */
function eal_deactivation() {
    // Cleanup your tables, transients etc. here
}
register_deactivation_hook(__FILE__, 'eal_deactivation');
