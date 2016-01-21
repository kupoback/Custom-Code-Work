<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              makattak.com
 * @since             1.0.0
 * @package           Admin_Panel
 *
 * @wordpress-plugin
 * Plugin Name:       Admin Panel
 * Plugin URI:        https://github.com/kupoback/Custom-Code-Work
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Nick
 * Author URI:        makattak.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       admin-panel
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-admin-panel-activator.php
 */
function activate_admin_panel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-admin-panel-activator.php';
	Admin_Panel_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-admin-panel-deactivator.php
 */
function deactivate_admin_panel() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-admin-panel-deactivator.php';
	Admin_Panel_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_admin_panel' );
register_deactivation_hook( __FILE__, 'deactivate_admin_panel' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-admin-panel.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_admin_panel() {

	$plugin = new Admin_Panel();
	$plugin->run();

}
run_admin_panel();
