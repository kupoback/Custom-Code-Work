<?php

/*
*	Plugin Name: Rhino Template Guess
*	Plugin URI: http://www.rhinogroup.com
*	Version: 1.0
*	Author: Rhino Group
*	Author http://www.rhinogroup.com
*	License: GPL v3
*
*	GNU General Public License for more details.
*
*	You should have received a copy of the GNU General Public License
*	along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class Rhino_Template_File {

	/** @var string $template_name */
	private $template_name = '';

	/** @var array $template_parts */
	private $template_parts = array();

public function __construct() {

	add_action( 'init', array( $this, 'frontend_hooks' ) );
	add_action( 'admin_init', array( $this, 'admin_hooks' ) );
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

}

function __rhino_template_file() {
	new Rhino_Template_File();
}

add_action( 'plugins_loaded', '__rhino_template_file' );

register_activation_hook( __FILE__, array( 'RhinoTemplateFile', 'plugin_activation' ) );