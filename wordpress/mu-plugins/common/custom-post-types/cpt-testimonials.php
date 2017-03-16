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
function org_create_post_type_testimonial() {
	
	$labels = array(
		'name'               => _x( 'Testimonials', 'post type general name' ),
		'singular_name'      => _x( 'Testimonial', 'post type singular name' ),
		'menu_name'          => _x( 'Testimonials', 'admin menu' ),
		'name_admin_bar'     => _x( 'Testimonial', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New Testimonial', 'add new on editor screen' ),
		'add_new_item'       => __( 'Add New Testimonial' ),
		'new_item'           => __( 'New Testimonial' ),
		'edit_item'          => __( 'Edit Testimonial' ),
		'view_item'          => __( 'View Testimonial' ),
		'all_items'          => __( 'All Testimonials' ),
		'search_items'       => __( 'Search Testimonials' ),
		'parent_item_colon'  => __( 'Parent Testimonials:' ),
		'not_found'          => __( 'No Testimonials found'),
		'not_found_in_trash' => __( 'No Testimonials found in Trash'),
	);
	
	$args = array(
		'labels'             => $labels,
		'menu_icon'          => 'dashicons-admin-users',
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'taxonomies'         => array(),
		'supports'           => array( 'title', 'thumbnail' )
	);	
	
    register_post_type( 'cpt_testimonial', $args );
}
add_action( 'init', 'org_create_post_type_testimonial', 0 );
