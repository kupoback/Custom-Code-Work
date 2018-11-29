<?php

/* Adding Image Upload Fields To User Profile */
function theme_add_user_media_field( $user ) {
  
  // Can be used if not on $user page
	//wp_nonce_field( 'theme_media_field_nonce', 'theme_media_field_nonce_process' );
	?>

	<h3>Profile Images</h3>

	<style type="text/css">
		.fh-profile-upload-options th,
		.fh-profile-upload-options td,
		.fh-profile-upload-options input {
			vertical-align : top;
		}

		.user-preview-image {
			display : block;
			height  : auto;
			width   : 300px;
		}

	</style>

	<table class="form-table fh-profile-upload-options">
		<tr>
			<th>
				<label for="title_label">Title Here</label>
			</th>

			<td>
				<label for="input_id"><?php _e( 'Field Label', 'events' ) ?></label><br>
				
        <input type="url" class="large-text" name="input_id" id="input_id" value="<?php echo esc_attr( get_the_author_meta( 'input_id', $user->ID ) ); ?>"><br>
				
        <button type="button" class="button" id="custom_media_upload_button" data-media-uploader-target="#input_id"><?php _e( 'Upload Media', 'textdomain' ) ?></button>

				<span class="description"><?php _e('Please upload an image for your profile.', 'textdomain'); ?></span>
			</td>
		</tr>

	</table>
	
	
	<?php
}

/** Load Scripts to Admin only */
function theme_load_admin_scripts( $hook ) {
    
  wp_enqueue_media();
    // Registers and enqueues the required javascript.
    
    // If via Plugin
    //wp_register_script( 'media-window', plugins_url( 'admin_js.js' , __FILE__ ), array( 'jquery' ) );
    
    // If via Theme
		wp_register_script( 'media-window', get_template_directory_uri() . '/assets/js/admin_js.js', [ 'jquery' ] );
    
    $js_args = [
      'title'  => __( 'Choose or Upload Media', 'events' ),
      'button' => __( 'Use this media', 'events' ),
    ];

    wp_localize_script( 'media-window', 'media_window', $js_args );
    
    wp_enqueue_script( 'media-window' );
}

/** Save the meta fields. */
function theme_save_extra_profile_fields( $user_id ) {
	
	if ( ! current_user_can( 'edit_user', $user_id ) ) return false; 
	
	update_user_meta( $user_id, 'input_id', $_POST['input_id'] );
}


// Activate our functions
add_action( 'show_user_profile', 'theme_add_user_media_field' );
add_action( 'edit_user_profile', 'theme_add_user_media_field' );
add_action( 'admin_enqueue_scripts', 'theme_load_admin_scripts', 10, 1 );
add_action( 'personal_options_update', 'theme_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'theme_save_extra_profile_fields' );