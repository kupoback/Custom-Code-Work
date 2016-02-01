(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	 $(function() {

		// Set up variables for the image upload and removing the image
		var frame,
			imgUploadButton 		= $( '#upload_login_logo_button' ),
			imgContainer 			= $( '#upload_logo_preview' ),
			imgIdInput 				= $( '#login_logo_id' ),
			imgPreview				= $( '#upload_logo_preview'),
			imgDelButton			= $( '#admin-panel-delete_logo_button' ),
			// Color Pickers inputs
			colorPickerInputs		= $( '.admin-panel-color-picker' );

		// WordPress specific plugins - color picker and image upload
		$( '.admin-panel-color-picker' ).wpColorPicker;

		// wp.media Add Image
		imgUploadButton.on( 'click', function( event ) {

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( frame ) {
				frame.open();
				return;
			}

			// Create a new media frame
			frame = wp.media( {
				title: 'Select or Upload Media for your Login Logo',
				button: {
					text: 'Use as my Login page Logo'
				},
				multiple: false // If set to true, will allow for multiple files to be selected
			});
			frame.on( 'select', function() {

				// Get media attachment details from the frame state
				var attachment = frame.state().get( 'selection' ).first().toJSON();

				//console.log(attachment); // Used to see attributes for use of .attr below

				// Send the atachment URL to our custom image input field.
				imgPreview.fint( 'img' ).attr( 'src', attachment.sizes.thumbnail.url );

				// Send the attachment id to our hidden input
				imgIdInput.val( attachment.id );

				// Unhide the remove image link
				imgPreview.removeClass( 'hidden' );

				// Finally, open the modal on click
				frame.open();

			});

			// Erase image url and age preview
			imgDelButton.on( 'click', function(e) {
				e.preventDefault();
				imgIdInput.val( '' );
				imgPreview.find( 'img' ).attr( 'src', '' );
				imgPreview.addClass( 'hidden' );
			});

		}); // End of DOM Ready


	 });

})( jQuery );
