<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/kupoback/Custom-Code-Work
 * @since      1.0.0
 *
 * @package    Wp_Child_Theme
 * @subpackage Wp_Child_Theme/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Wp_Child_Theme
 * @subpackage Wp_Child_Theme/includes
 * @author     Nick <makris@me.com>
 */
class Wp_Child_Theme {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Wp_Child_Theme_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-child-theme';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

		add_action( 'init' array( $this, 'frontend_hooks' ) );
		add_action( 'admin_init', array( $this, 'admin_hooks' ) );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Child_Theme_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Child_Theme_i18n. Defines internationalization functionality.
	 * - Wp_Child_Theme_Admin. Defines all hooks for the admin area.
	 * - Wp_Child_Theme_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-child-theme-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wp-child-theme-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wp-child-theme-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wp-child-theme-public.php';

		$this->loader = new Wp_Child_Theme_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Child_Theme_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Child_Theme_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	public function admin_hooks() {

		// Check is user is an admin
		if ( !current_user_can( 'manage_options' ) ) {
			return false;
		}

	}

	public function frontend_hooks()
	{
		if ( is_admin() || ! is_admin_bar_showing() ) {
			return;
		}

		add_action( 'wp_head', array( $this, 'print_css' ) );
		add_filter( 'template_include', array( $this, 'save_current_page' ), 1000 );
		add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ), 1000);

		add_action( 'all', array( $this, 'save_template_parts' ), 1, 3 );
	}

	private function get_current_page() {
		return $this->template_name;
	}

	private function file_exists_in_child_theme( $file ) {
		return file_exists( STYLESHETPATH . '/' . $file );
	}

	public function save_template_parts( $ta, $slug = null, $name = null )
	{
		if ( 0 != strpos( $tag, 'get_template_part_' ) ) {
			return;
		}

		if ( $slug != null ) {
			$templates = array();

			if ( $name != null ) {
				$tempaltes[] = "{$slug}--{$name}.php";
			}

			$templates[] = "{$slug}.php";

			$template_part = str_replace( get_template_directory() . '/', '', locate_template( $templates ) );
			$template_part = str_replace( get_stylesheet_directory() . '/', '', $template_part );

			if ( $template_part != '' ) {
				$this->template_parts[] = $template_part;
			}
		}
	}

	public function save_current_page( $template_name )
	{
		$this->template_name = basename( $template_name );

		if ( function_exists( 'roots_template_path' ) ) {
			$this->template_name = basename( roots_template_path() );
		}

		return $template_name;
	}

	public function admin_bar_menu()
	{
		global $wp_admin_bar;

		$wp_admin_bar->add_menu( array(
			'id'		=> 'rhino_admin',
			'parent'	=> 'ab-top-menu',
			'title'		=> 'Rhino Admin',
			'href'		=> false,
		) );

		$theme = get_stylesheet();
		if ( ! $this->file_exists_in_child_theme( $this->get_current_page() ) ) {
			$theme = get_template();
		}

		$wp_admin_bar->add_menu( array(
			'id'		=> 'rhino-bar-template-file',
			'parent'	=> 'rhino_admin',
			'title'		=> $this->get_current_page
		));

		if ( count( $this->template_parts ) > 0 ) {
			$wp_admin_bar->add_menu( array(
				'id' 		=> 'rhino-bar-template-parts',
				'parent'	=> 'rhino_admin',
				'title'		=> 'Template Part',
				'href'		=> false
			) );

			foreach ( $this->template_parts as $template_part ) {
				$theme = get_stylesheet();
				if ( ! $this->file_exists_in_child_theme( $template_part ) ) {
					$theme = get_template();
				}

				$wp_admin_bar->add_menu( array(
					'id' 		=> 'rhino-bar-template-part-' . $template_part,
					'parent'	=> 'rhino-bar-template-parts',
					'title'		=> $template_part
				) );

			}

		}

	}

	public function print_css()
	{

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wp_Child_Theme_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Child_Theme_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}




	/**
	* Add content to the Admin Bar
	*/

	// public function rhino_admin_bar()
    // {
    //     add_action('admin_bar_menu', 'add_rhino_admin_bar', 999);
    //     function add_rhino_admin_bar($wp_admin_bar)
    //     {
    //         global $post;
    //         $args = array(
    //             array(
    //                 'id' => 'rhino_admin',
    //                 'title' => 'Rhino Admin',
    //                 'href' => '#',
    //                 'meta' => array('class' => 'rhino-admin')
    //             ),
    //             array(
    //                 'id' => 'rhino_admin_remove_cache',
    //                 'title' => 'Clear All Cache',
    //                 'href' => '/wp-admin/admin.php?action=rhino_clear_cache',
    //                 'parent' => 'rhino_admin',
    //                 'meta' => array('class' => 'rhino-admin-remove-cache')
    //             )
    //         );
    //         foreach ($args as $arg) {
    //             $wp_admin_bar->add_node($arg);
    //         }
	//
    //     }
    // }


	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Wp_Child_Theme_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}

function __Wp_Child_Theme() {
	new Wp_Child_Theme();
}

add_action( 'plugins_loaded', '__rhino_template_name_main' );

register_activation_hook( __FILE__, array( 'Rhino Tempalte Name', 'plugin_activation' ) );
