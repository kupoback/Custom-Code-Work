<?php
/**
 *  Custom Shortcode: Testimonial
 *
 *  @package CPT_Button
 *
 *  @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 *  @version     1.0.0
 *
 *  Plugin Name: Shortcode: cpt_testimonial
 *  Plugin URI:
 *  Description: A shortcode for displaying a Button custom post type.
 *  Version:     1.0.0
 *  Domain Path: /lang
 *  License:     GPL-2.0+
 *  License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


// No direct access
if ( ! defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}


/**
 *  Initialize the Shortcode
 *
 *  @since 1.0.0
 */
function shortcode_cpt_testimonial_init() {
	add_shortcode( 'cpt_testimonial', 'cpt_shortcode_cpt_testimonial' );
}
add_action( 'init', 'shortcode_cpt_testimonial_init' );


/**
 *  Shortcode: cpt_button
 *
 *  Displays the image, sub title, link, and content
 *
 *  @since 1.0.0
 */
function cpt_shortcode_cpt_testimonial( $atts, $content = null ){

	$atts = shortcode_atts(
		array(
			'id' => 0,
			'output'   => 'OBJECT',
			'filter'   => 'raw',
			),
		$atts,
    // Set to your post_type
		'testimonial'
	);

	$id = absint( $atts['id'] );

	// if there's no ID
	if( ! $id ){
		return $content;
	}

	$post_args = array(
		'post'   => $id,
		'output' => $atts['output'],
		'filter' => $atts['filter'],
	);

	$post_args = apply_filters( 'org_cpt_testimonial_shortcode_args', $post_args );

	$testimonial_post = get_post( $post_args['post'], $post_args['output'], $post_args['filter'] );
	
	if ( ! is_null( $testimonial_post ) ) :

		//$testimonial_content = ( ! empty( $testimonial_post->post_content ) ) ? $testimonial_post->post_content : '' ;

		$fields = ( function_exists( 'get_fields' ) ) ? get_fields( $id ) : array();
   
    ob_start();
    
    // Start your code here
    
		$content = ob_get_clean();

	endif;

	wp_reset_postdata();

	return apply_filters( 'org_shortcode_cpt_testimonial_content', $content);
}
