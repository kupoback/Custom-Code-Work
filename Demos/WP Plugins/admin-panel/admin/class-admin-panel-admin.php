<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       makattak.com
 * @since      1.0.0
 *
 * @package    Admin_Panel
 * @subpackage Admin_Panel/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Admin_Panel
 * @subpackage Admin_Panel/admin
 * @author     Nick <makris@me.com>
 */
class Admin_Panel_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Admin_Panel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Admin_Panel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin-panel-admin.css', array(), $this->version, 'all' );

		// Loads only if on that specific page
		if ( 'setting_page_admin-panel' == get_current_screen() -> id ) {
			// CSS stylesheet for Color Picker
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_style( $this->$plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin-panel-admin.css', array('wp-color-picker'), $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Admin_Panel_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Admin_Panel_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin-panel-admin.js', array( 'jquery' ), $this->version, false );

		// Loads only if on that specific page
		if ( 'settings_page_admin-panel' == get_current_screen() -> id ) {
			wp_enqueue_media();
			wp_enqueue_script( $this->$plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin-panel-admin.js', array( 'jquery', 'wp-color-picker' ), $this->$version, false);
		}

	}

	/**
 	* Register the administration menu for this plugin into the WordPress Dashboard menu.
	*/

	public function add_plugin_admin_menu() {

	/*
	* Add a settings page for this plugin to the Settings Menu
	*
	* Alternate Locations Found Here: http://codex.wordpress.org/Administration_Menus
	*/
		// Takes 5 args, Page Title, Menu Title, Capabilities ( who can access ), Menu Slug, Callback Function (Where the options/content in the backend will be displayed)
		add_options_page( 'WP Cleanup & Base Options Setup', 'WP Cleanup', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page' ) );
	}

	/**
	* Add settings action link to the plugins page
	* Adds a "Settings" link to the 'Deactivate | Edit' list when plugin is activated
	*/
	public function add_action_links( $links ) {
		/*
	    *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	    */

		// This takes 1 args, the $links array, which is then merged when returned
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
			array_merge(  $settings_link, $links );
		);
	}

	/**
	* Render the settings page
	*/
	public function display_plugin_setup_page() {
		// Calls to the file that will render the markup for the page, HTML/CSS/PHP
		include_once( 'partials/admin-panel-admin-display.php' );
	}

	public function validate( $input ) {

			// All checkbox inputs
			$valid = array();

			// Cleanup
			// isset and !empty check whether the checkbox is marked or not.
			$valid['cleanup'] = ( isset( $input['cleanup'] ) && !empty ( $input['cleanup'] ) ) ? 1 : 0;
			$valid['comments_css_cleanup'] = ( isset( $input['comments_css_cleanup'] ) && !empty( $input['comments_css_cleanup'] ) ) ? 1 : 0;
			$valid['gallery_css_cleanup'] = ( isset( $input['gallery_css_cleanup'] ) && !empty( $input['gallery_css_cleanup'] ) ) ? 1 : 0;
			$valid['body_class_slug'] = ( isset( $input['body_class_slug'] ) && !empty( $input['body_class_slug'] ) ) ? 1 : 0;
			$valid['jquery_cdn'] = ( isset( $input['jquery_cdn'] ) && !empty( $input['jquery_cdn'] ) ) ? 1 : 0;
			$valid['cdn_provider'] = esc_url( $input['cdn_provider'] );

			// Login Customization
			//First Color Picker
			// Checks to make sure $input is not empty
			$valid['login_background_color'] = (isset($input['login_background_color']) && !empty($input['login_background_color'])) ? sanitize_text_field($input['login_background_color']) : '';

			// If validation fails, we give the user some feedback to correct the error.
			if ( !empty($valid['login_background_color']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['login_background_color']  ) ) { 	// if user insert a HEX color with #
			   add_settings_error(
					   'login_background_color',                     		// Setting title
					   'login_background_color_texterror',            		// Error ID
					   'Please enter a valid hex value color',     			// Error message
					   'error'                         						// Type of message
			   );
			}

			//Second Color Picker
			$valid['login_button_primary_color'] = (isset($input['login_button_primary_color']) && !empty($input['login_button_primary_color'])) ? sanitize_text_field($input['login_button_primary_color']) : '';

			if ( !empty($valid['login_button_primary_color']) && !preg_match( '/^#[a-f0-9]{6}$/i', $valid['login_button_primary_color']  ) ) {  // if user insert a HEX color with #
			   add_settings_error(
					   'login_button_primary_color',                     	// Setting title
					   'login_button_primary_color_texterror',            	// Error ID
					   'Please enter a valid hex value color',     			// Error message
					   'error'                        						// Type of message
			   );
		   	}

			//Logo image id
			// Checks the $input['login_logo_id'] is set, otherwise set it to 0 which is false when empty() checks it.
			// If it is true, absint sets the int to a postive value
	        $valid['login_logo_id'] = (isset($input['login_logo_id']) && !empty($input['login_logo_id'])) ? absint($input['login_logo_id']) : 0;

		return $valid;

	}

	/**
	* Save Options
	*/
	public function options_update() {
		// Part of WP API,
		// Accepts:
		//	• option group (in this case plugin name for safety)
		//	• option name register each option as a single, using plugin name for safety
		//	• callback function used to sanitize our options with the validation function

		register_setting( $this->plugin_name, $this->plugin_name, array( $this, 'validate' ) );
	}

}
