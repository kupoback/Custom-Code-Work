<?php
/**
 *  Common functions for the site
 *  
 *  @package RMDL
 *  @subpackage Administration
 *  @since 1.0.0
 */


/**
 * Disable the XML-RPC service
 *
 * No since leaving a door open you're not using
 *
 */
 
/**
 *  Disable the XML-RPC service
 *  
 *  (No sense leaving a door open you're not using.)
 *  
 *  @since 1.0.0
 */
add_filter('xmlrpc_enabled', '__return_false');


#add_filter( 'bulk_actions-' . 'edit-post', '__return_empty_array' );
#add_filter( 'bulk_actions-' . 'edit-page', '__return_empty_array' );



/**
 *  Utility function for debugging output
 *  
 *  @since 1.0.0
 */
if ( ! function_exists( '_debug' ) ) :
function _debug($var){
    echo "\n<pre style=\"text-align:left;\">";
    if( is_array($var) || is_object($var)){
        print_r($var);
    } else {
        var_dump($var);
    }
    echo "</pre>\n";
}
endif;


/**
 *  Utility function to grab the parameter whether it's a get or post
 *  
 *  @since 1.0.0
 */
if ( ! function_exists( '_rmdl_get_param' ) ) :
function _rmdl_get_param($param, $default='') {
	return (isset($_POST[$param])?$_POST[$param]:(isset($_GET[$param])?$_GET[$param]:$default));
}
endif;


/**
 *  Allow all post-types for post_tag taxonomy queries
 *
 *  Without this, WP will only look for post_tag taxonomies on the "post" post-type
 *  
 *  @since 1.0.0
 */
function post_type_tags_fix($request) {
    if ( isset($request['tag']) && !isset($request['post_type']) )
		$request['post_type'] = 'any';

    return $request;
};
add_filter('request', 'post_type_tags_fix');


/**
 * Allow all post-types for category taxonomy queries
 *
 * Without this, WP will only look for category taxonomies on the "post" post-type
 *  
 *  @since 1.0.0
 */
function post_type_category_fix($request) {
    if ( isset($request['category_name']) && !isset($request['post_type']) )
		$request['post_type'] = 'any';

    return $request;
};
add_filter('request', 'post_type_category_fix');


/**
 * Remove the html filtering from Term descriptions
 *
 *  
 * @since 1.0.0
 */
remove_filter( 'pre_term_description', 'wp_filter_kses' );
remove_filter( 'term_description', 'wp_kses_data' );


/**
 * Add help tab displaying the Post ID to the Editor Screen
 */
function _cp_network_admin_add_help_tab() {
	global $pagenow, $post, $post_type;
	
	if( null === $post_type ) {
		$post_type = ( isset($_GET['post_type']) && !empty($_GET['post_type']) ) ? $_GET['post_type'] : '' ;
	}
	
	if ('post.php' == $pagenow  && (isset($_GET['action'])&& 'edit' == $_GET['action']) ) {
		$postid = ($post && '' != $post->ID ) ? $post->ID : $_GET['post'];
		$post_id_text = '<p>' . __('Your post id is: <strong>' . $postid . '</strong>  <br /><br />This number should match the number in the URL above where it says &#8220;<code>post=###</code>&#8221;.') . '</p>';
		get_current_screen()->add_help_tab( array(
			'id'      => 'your-post-id',
			'title'   => __('Post ID'),
			'content' => $post_id_text,
		) );
	}
	
	if('page' === $post_type ){
		$page_attributes = '<p>' . __('<strong>Page Template: </strong>Certain page templates utilize custom meta boxes. Unless creating a standard page, be sure to always select the <a href="#page_template">page template</a> <i>before</i> entering any content.') . '</p>';			
		get_current_screen()->add_help_tab( array(
			'id' => 'template-metaboxes',
			'title' => __('Template Meta Boxes'),
			'content' => $page_attributes,
		) );
	}
	
}
add_action('load-post.php', '_cp_network_admin_add_help_tab');
add_action('load-post-new.php', '_cp_network_admin_add_help_tab');


/**
 * Load a template file on singe-post-type page (if applicable)
 *
 * Works for all post-types
 */
function show_me_the_template($template) {
	if( !is_archive() ) {
		$id = get_queried_object_id();
		$template_name = get_post_meta($id, '_wp_page_template', true);
		$new_template = locate_template($template_name);

		if('' != $new_template)
			$template = $new_template;
	}
    return $template;
}
#add_filter( 'template_include', 'show_me_the_template' );


/**
 *  Removes the WP version param from any enqueued scripts
 */
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
#add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
#add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );


/**
 * Remove the inline style for the Recent Comments Widget
 */
add_filter( 'show_recent_comments_widget_style', '__return_false' );


/**
 * Chunk a string at XX characters
 */
function abbreviate($text, $max = '95') {
	if( strlen($text) <= $max ) {
		return $text;
	}
	return substr($text, 0, $max-3) . '&#8230;';
}


/**
 * array_filter a multidimensional array
 */
function _cp_array_filter_recursive($array) {
	if( !is_array($array) ){
		return;
	}
   foreach ($array as $key => &$value) {
      if (empty($value)) {
         unset($array[$key]);
      }
      else {
         if (is_array($value)) {
            $value = _cp_array_filter_recursive($value);
            if (empty($value)) {
               unset($array[$key]);
            }
         }
      }
   }

   return $array;
}


/**
 * Remove the Screen Options tab in the Admin
 */
function _cp_remove_screen_options_tab() {
	#return false;
	return current_user_can( 'manage_options' );
}
add_filter('screen_options_show_screen', '_cp_remove_screen_options_tab');
