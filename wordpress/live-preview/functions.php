// This is used on Navy Pier to allow the client to see 2 variations of the style
// updates they are requesting. This is tied into a function for the customizer.
// This code is in the header.
<?php // Start function to swap stylesheets ?>
  <?php
    $theme_mod = get_theme_mod( 'np_stylesheet_selector' );
    if ( $theme_mod == 'color_1' ) {
    ?>
      <link rel="stylesheet" class="swap" type="text/css" href="/wp-content/themes/navypier/css/color-rework-2017-1.css">
    <?php } elseif ( $theme_mod == 'color_2' ) { ?>
      <link rel="stylesheet" class="swap" type="text/css" href="/wp-content/themes/navypier/css/color-rework-2017-2.css">
    <?php } ?>
  <?php // End function to swap stylesheets ?>
 
// This begins the addition of the Customizer addition

function np_customize_register( $wp_customize ) {
	//All our sections, settings, and controls will be added here
	$wp_customize->add_section( 'np_new_section' , array(
		'title'      => __( 'Stylesheet Selection', 'navypier' ),
		'priority'   => 30,
	) );
	
  // Our setting that is nested inside the Section 'np_new_section'
	$wp_customize->add_setting('np_stylesheet_selector', array(
		'default'        => 'value1',
		'capability'     => 'edit_theme_options',
		'type'           => 'theme_mod',
    'transport'      => 'refresh',
	
	));
  
  // The dropdown options within the 'np_stylesheet_selector' setting
	$wp_customize->add_control( 'np_stylesheet_select_box', array(
		'settings' => 'np_stylesheet_selector',
		'label'   => 'Select A Stylesheet:',
		'section' => 'np_new_section',
		'type'    => 'select',
		'choices'    => array(
			'select' => 'Select',
			'color_1' => 'Color Rework 1',
      'color_2' => 'Color Rework 2'
		),
	));
	
}
add_action( 'customize_register', 'np_customize_register' );

// This function ties into the Live Preview
function np_customizer_live_preview() {
	wp_enqueue_script(
		// Give the script an ID
    'np-themecustomizer',			
    // Point to file
		get_template_directory_uri().'/js/np-customize.js',
		// Define dependencies
    array( 'jquery','customize-preview' ),	
    // Define a version (optional)
    '',
    // Put script in footer?
    true						
	);
}
add_action( 'customize_preview_init', 'mytheme_customizer_live_preview' );
