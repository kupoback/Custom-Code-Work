<?php
/**
	 * Function Name: nf_add_to_inspiring_stories_pt
	 * Description: Takes the form submission fields and sets them to post meta data depending
	 * on the post type selected. This can be adjusted as needed, and in example is using ACF.
	 * Version: 1.0
	 * Author: Nick Makris @kupoback
	 * Author URI: https://makris.io
	 *
	 * @package positioningforsuccessbook
	 *
	 * @param $form_data
	 * 
	 */
	function nf_add_to_inspiring_stories_pt( $form_data ) {
		$post_fields = [];
		$form_id     = $form_data['form_id'];
		$form_fields = $form_data['fields'];
		
		// We're going to loop through our form fields here
		// and compare them to each other
		foreach ( $form_fields as $field ) {
			
			$field_id    = $field['id'];
			$field_key   = $field['key'];
			$field_value = $field['value'];
			
			// Sloppy method of laying out of fields
			// @TODO Find an alternate method to shorten this
			
			if ( 'is_full_name' === $field_key )
				$post_fields['title'] = $field_value;
			
			if ( 'is_company_title' === $field_key )
				$post_fields['company_title'] = $$field_value;
			
			if ( 'is_organization_company_name' === $field_key )
				$post_fields['organization_company_name'] = $field_value;
			
			if ( 'is_story_title' === $field_key )
				$post_fields['story_title'] = $field_value;
			
			if ( 'is_about_the_company' === $field_key )
				$post_fields['_about_the_company'] = $field_value;
			
			if ( 'is_the_challenge' === $field_key )
				$post_fields['the_challenge'] = $field_value;
			
			if ( 'is_the_solution' === $field_key )
				$post_fields['the_solution'] = $field_value;
			
			if ( 'is_the_result' === $field_key )
				$post_fields['the_result'] = $field_value;
			
			if ( 'is_upload_a_photo' === $field_key )
				$post_fields['upload_a_photo'] = $field_value;
			
			if ( 'is_upload_a_logo' === $field_key )
				$post_fields['upload_a_logo'] = $field_value;
			
		}
		
		// Since Ninja Forms is setting to this an array, we need to know when and where to get the items.
		$post_thumbnail_id = attachment_url_to_postid( implode( '', $post_fields['upload_a_photo'] ) );
		$logo_thumbnail_id = attachment_url_to_postid( implode( '', $post_fields['upload_a_logo'] ) );
		
		// Setup our new post items to pass into the fields
		// We need to make all these form submissions into pending posts
		$post = [
			'post_type'      => 'cpt_stories',
			'post_title'     => $post_fields['title'],
			'post_name'      => sanitize_title( $post_fields['title'] ),
			// Bypasses post reviews
			//			'post_status' =>  'publish'
			// Sets post to be reviewed
			'post_status'    => 'pending',
			// Other parameters
			'comment_status' => 'closed',
			'ping_status'    => 'closed',
		];
		
		// We'll make our post here, but since we're using ACF, we need it's ID
		// so we set it to a variable
		$post_id = wp_insert_post( $post );
		
		if ( !is_wp_error( $post_id ) )
			update_post_meta( $post_id, '_thumbnail_id', $post_thumbnail_id );
		
		// Here are the ACF items we want to feed into. Note we are using the field
		// and not the name of the field.
		$acf_data = [
			'field_company_title'     => $post_fields['company_title'],
			'field_company_name'      => $post_fields['organization_company_name'],
			'field_story_title'       => $post_fields['story_title'],
			'field_about_the_company' => $post_fields['_about_the_company'],
			'field_the_challenge'     => $post_fields['the_challenge'],
			'field_the_solution'      => $post_fields['the_solution'],
			'field_the_result'        => $post_fields['the_result'],
			'field_story_logo'        => $logo_thumbnail_id,
		];
		
		// Lets set our field values here
		foreach ( $acf_data as $key => $data ) {
			update_field( $key, $data, $post_id );
		}
		
	}
	
	add_action( 'theme_ninja_forms_post_processing', 'nf_add_to_inspiring_stories_pt' );
