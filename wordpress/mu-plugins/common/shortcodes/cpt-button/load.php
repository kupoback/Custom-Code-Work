<?php
/**
 *  Custom Shortcode: Cutsom Post Type Button
 *
 *  @package CPT_Button
 *
 *  @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 *  @version     1.0.0
 *
 *  Plugin Name: Shortcode: CPT_Button
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
function shortcode_cpt_button_init() {
	add_shortcode( 'cpt_button', 'shortcode_cpt_button' );
}
add_action( 'init', 'shortcode_cpt_button_init' );


/**
 *  Shortcode: cpt_button
 *
 *  Displays the image, sub title, link, and content
 *
 *  @since 1.0.0
 */
function shortcode_cpt_button( $atts, $content = null ){

	$atts = shortcode_atts(
		array(
			'id' => 0,
			'output'   => 'OBJECT',
			'filter'   => 'raw',
			),
		$atts,
    // Button Custom Post Type
		'button'
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

	$post_args = apply_filters( 'dbdb_cpt_button_shortcode_args', $post_args );

	$button_post = get_post( $post_args['post'], $post_args['output'], $post_args['filter'] );

	if ( ! is_null( $button_post ) ) :

		$button_content = ( ! empty( $button_post->post_content ) ) ? $button_post->post_content : '' ;

		$fields = ( function_exists( 'get_fields' ) ) ? get_fields( $id ) : array();
		$f_object = ( function_exists( 'get_field_objects' ) ) ? get_field_objects( $id ) : array();
		
		ob_start();
    
		$content = ob_get_clean();

	endif;

	wp_reset_postdata();

	return apply_filters( 'shortcode_cpt_btn_content', $content);
}
