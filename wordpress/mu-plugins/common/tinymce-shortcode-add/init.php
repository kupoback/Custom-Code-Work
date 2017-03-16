<?php
/**
 * Created by PhpStorm.
 * User: nickmakris
 * Date: 2/17/17
 * Time: 10:47 AM
 */
// init process for registering our button
add_action('init', 'wpse72394_shortcode_button_init');
function wpse72394_shortcode_button_init() {
  
  //Abort early if the user will never see TinyMCE
  if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') && get_user_option('rich_editing') == 'true')
    return;
  
  //Add a callback to regiser our tinymce plugin
  add_filter("mce_external_plugins", "wpse72394_register_tinymce_plugin");
  
  // Add a callback to add our button to the TinyMCE toolbar
  add_filter('mce_buttons', 'wpse72394_add_tinymce_button');
}


//This callback registers our plug-in
function wpse72394_register_tinymce_plugin($plugin_array) {
  $plugin_array['wpse72394_cpt_button'] = '/wp-content/mu-plugins/common/tinymce-shortcode/js/shortcode.js';
  $plugin_array['wpse72394_cpt_testimonial'] = '/wp-content/mu-plugins/common/tinymce-shortcode/js/shortcode.js';
//  $plugin_array['wpse72394_slider_button'] = '/wp-content/mu-plugins/common/tinymce-shortcode/js/shortcode.js';
  return $plugin_array;
}

//This callback adds our button to the toolbar
function wpse72394_add_tinymce_button($buttons) {
  //Add the button ID to the $button array
  $buttons[] = "wpse72394_cpt_button";
  $buttons[] = "wpse72394_cpt_testimonial";
  return $buttons;
}
