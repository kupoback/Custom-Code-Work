<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       makattak.com
 * @since      1.0.0
 *
 * @package    Admin_Panel
 * @subpackage Admin_Panel/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Admin_Panel
 * @subpackage Admin_Panel/public
 * @author     Nick <makris@me.com>
 */
class Admin_Panel_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->$admin_panel_options = get_option($this->$plugin_name);				// This gets the save options to use in function

	}

	/**
	* Cleanup functions depending on each checkbox returned value in admin
	*/
	public function admin_panel_cleanup {
		// Cleanup head

		if( $this->$admin_panel_options['cleanup'] ){

			remove_action( 'wp_head', 'rsd_link' ); 									// RSD Link
			remove_action( 'wp_head', 'feed_links_extra', 3 ); 							// Category feed link
			remove_action( 'wp_head', 'feed_links', 2 ); 								// Post and Comment Feed Links
			remove_action( 'wp_head', 'index_rel_link' );
			remove_action( 'wp_head', 'wlwmanifest_link' );
			remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); 					// Parent rel link
			remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); 					// Start post rel link
			remove_action( 'wp_head', 'rel_canonical', 10, 0 );
			remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
			remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 		// Adjacent post rel link
			remove_action( 'wp_head', 'wp_generator' ); 								// WP Version
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'wp_print_styles', '' );
		}
	}

	// Cleanup head
	public function admin_panel_remove_x_pingback( $headers ) {
		if( !empty( $this->admin_panel_options['cleanup'] ) ) {
			unset( $headers['X-Pingback'] );
			return $headers;
		}
	}

	// Remove Comment Inline CSS
	public function admin_panel_remove_comments_inline_styles() {
		if( !empty($this->admin_panel_options['comments_css_cleanup'] ) ) {
			global $wp_widget_factory;
			if ( has_filter( 'wp_head', 'wp_widget_recent_comments_styles' ) ) {
				remove_filter( 'wp_head', 'wp_widget_recent_comments_styles' );
			}

			if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
				remove_action( 'wp_head', array( $wp_widget_factory->widget['WP_Widget_Recent_Comments'] ) );
			}
		}
	}

	// Remove gallery inline CSS
	public function admin_panel_remove_gallery_styles( $css ) {
		if( !empty( $this->admin_panel_options['gallery_css_cleanup'] ) ) {
			return preg_replace( "!<style type='text/css'>(.*?)</style>!s", '', $css );
		}
	}

	// Add post/page slug
	public function admin_panel_body_class_slug( $classes)
	{
		if ( !empty( $this->admin_panel_options['body_class_slug' ] ) ) {
			global $post;
			if ( is_singlular() ) {
				$classes[] = $post->post_name;
			}
		}

		return $classes;
	}

	// Load jQuery from CDN if available
	public function admin_panel_cdn_jquery()
	{
		if ( !empty($this->admin_panel_options[ 'jquery_cdn' ] ) ) {
			if ( !is_admin ) {
				if ( !empty($this->admin_panel_options['cdn_provider'] ) ) {
					$link = $this->admin_panel_options['cdn_provider'];
				}
				else {
					$link = '//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js';
				}
				$try_url = @fopen( $link, 'r' );
				if ( $try_url != false ){
					wp_deregister_script( 'jquery' );
					wp_register_script( 'jquery', $link, array(), null, false);
				}
			}
		}
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/admin-panel-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/admin-panel-public.js', array( 'jquery' ), $this->version, false );

	}

}
