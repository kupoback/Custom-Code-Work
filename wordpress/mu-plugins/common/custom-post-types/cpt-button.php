<?php
/**
 *  Register Custom Post Type
 *  
 *  @link http://codex.wordpress.org/Function_Reference/register_post_type
 *  
 *  @since 1.0.0
 *  
 *  @package Custom
 *  @subpackage Admin
 *  @since 1.0.0
 */
function org_create_post_type_button() {
	
	$labels = array(
		'name'               => _x( 'Buttons', 'post type general name' ),
		'singular_name'      => _x( 'Button', 'post type singular name' ),
		'menu_name'          => _x( 'Button', 'admin menu' ),
		'name_admin_bar'     => _x( 'Button', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New Button', 'add new on editor screen' ),
		'add_new_item'       => __( 'Add New Button' ),
		'new_item'           => __( 'New Button' ),
		'edit_item'          => __( 'Edit Button' ),
		'view_item'          => __( 'View Button' ),
		'all_items'          => __( 'All Buttons' ),
		'search_items'       => __( 'Search Buttons' ),
		'parent_item_colon'  => __( 'Parent Buttons:' ),
		'not_found'          => __( 'No Buttons found'),
		'not_found_in_trash' => __( 'No Buttons found in Trash'),
	);
	
	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-admin-links',
		'public'             => false,
		'publicly_queryable' => false,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'cpt_button' ),
		'capability_type'    => 'page',
		'has_archive'        => false,
		'hierarchical'       => false,
		#'menu_position'      => null,
		'taxonomies'         => array(),
		'supports'           => array( 'title' )
	);	
	
    register_post_type( 'cpt_button', $args );
}
add_action( 'init', 'org_create_post_type_button', 0 );
