<?php
/*
Plugin Name: Ethical MedTech Custom TinyMCE Plugin
Description: A WordPress plugin that will add flexible content shortcode and table plugin to the tinyMCE editor
Author: Ling Cao
Author URI: http://www.acw.uk.com
Version: 1.0
License: GPL2
*/

new Shortcode_Tinymce();

class Shortcode_Tinymce
{

    /* Handles initializing this class and returning the singleton instance after it's been cached.
	 *
	 * @return null|MCE_Table_Buttons
	 */
	public static function get_instance() {
		// Store the instance locally to avoid private static replication
		static $instance = null;

		if ( null === $instance ) {
			$instance = new self();
			self::_setup_plugin();
		}

		return $instance;
	}


    public function __construct()
    {
        add_action('admin_init', array($this, 'pu_shortcode_button'));
    }

    /**
     * Create a shortcode button for tinymce
     *
     * @return [type] [description]
     */
    public function pu_shortcode_button()
    {
        if( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
        {
           //add_filter( 'mce_external_plugins', array($this, 'pu_add_buttons' ));
        }
    }

    /**
     * Handles registering hooks that initialize this plugin.
     */
    public static function _setup_plugin() {

        add_filter( 'mce_external_plugins', array( __CLASS__, 'mce_external_plugins'));
        add_filter( 'mce_buttons', array(__CLASS__, 'pu_register_buttons' ));
        add_filter( 'mce_buttons_2', array( __CLASS__, 'mce_buttons_2'));
        add_filter( 'content_save_pre', array( __CLASS__, 'content_save_pre' ), 20 );

    }

    /**
     * Add new Javascript to the plugin scrippt array
     *
     * @param  Array $plugin_array - Array of scripts
     * @return Array
     */
    public function pu_add_buttons( $plugin_array )
    {
        $plugin_array['pushortcodes'] = plugin_dir_url( __FILE__ ) . 'customeditorbtn.js';

        return $plugin_array;
    }

    /**
     * Add new button to tinymce
     *
     * @param  Array $buttons - Array of buttons
     * @return Array
     */
    public static function pu_register_buttons( $buttons )
    {
        array_push( $buttons, 'separator', 'anchor', 'pushortcodes' );
        return $buttons;
    }


    /**
     * Initialize TinyMCE table plugin and custom TinyMCE plugin
     *
     * @param array $plugin_array Array of TinyMCE plugins
     * @return array Array of TinyMCE plugins
     */
    public static function mce_external_plugins( $plugin_array )
    {
        global $tinymce_version;
        $variant = ( defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ) ? '' : '.min';

        if ( version_compare( $tinymce_version, '4100', '>=' ) ) {
            $plugin_array['table'] = plugin_dir_url( __FILE__ ) . 'tinymce41-table/plugin' . $variant . '.js';
        }

        $plugin_array['anchor'] = plugin_dir_url( __FILE__ ) . 'anchor/plugin.min.js';

        return $plugin_array;
    }

    /**
     * Add TinyMCE table control buttons
     *
     * @param array $buttons Buttons for the second row
     * @return array Buttons for the second row
     */
    public static function mce_buttons_2( $buttons )
    {
        global $tinymce_version;

        if ( version_compare( $tinymce_version, '400', '<' ) ) {

            add_filter( 'mce_buttons_3', array( __CLASS__, 'mce_buttons_3' ) );

        } else {

            // in case someone is manipulating other buttons, drop table controls at the end of the row
            if ( ! $pos = array_search( 'undo', $buttons ) ) {
                array_push( $buttons, 'table');
                return $buttons;
            }

            $buttons = array_merge( array_slice( $buttons, 0, $pos ), array( 'table' ), array_slice( $buttons, $pos ) );

        }

        return $buttons;
    }

    /**
     * Add TinyMCE 3.x table control to the second row, after other formatting controls
     *
     * @param array $buttons Buttons for the second row
     * @return array Buttons for the second row
     */
    public static function mce_buttons_3( $buttons )
    {
        array_push( $buttons, 'tablecontrols');

        return $buttons;
    }

    /**
     * Fixes weirdness resulting from wpautop and formatting clean up not built for tables
     *
     * @param string $content Editor content before WordPress massaging
     * @return string Editor content before WordPress massaging
     */
    public static function content_save_pre( $content )
    {
        if ( false !== strpos( $content, '<table' ) ) {
            // paragraphed content inside of a td requires first paragraph to have extra line breaks (or else autop breaks)
            $content  = preg_replace( "/<td([^>]*)>(.+\r?\n\r?\n)/m", "<td$1>\n\n$2", $content );

            // make sure there's space around the table
            if ( substr( $content, -8 ) == '</table>' ) {
                $content .= "\n<br />";
            }
        }

        return $content;
    }

}

Shortcode_Tinymce::get_instance();
