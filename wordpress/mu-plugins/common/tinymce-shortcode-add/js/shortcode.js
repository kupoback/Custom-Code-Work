jQuery(document).ready(function($) {
  
  tinymce.create('tinymce.plugins.wpse72394_plugin', {
    init : function(ed, url) {
      // Register command for when button is clicked
      ed.addCommand('wpse72394_add_cpt_button_shortcode', function() {
        selected = tinyMCE.activeEditor.selection.getContent();
        
        if( selected ){
          //If text is selected when button is clicked
          //Wrap shortcode around it.
          content =  '[cpt_button id="'+selected+'"]';
        }else{
          content =  '[cpt_button id=""]';
        }
        
        tinymce.execCommand('mceInsertContent', false, content);
      });
      ed.addCommand('wpse72394_add_cpt_testimonials_shortcode', function() {
        selected = tinyMCE.activeEditor.selection.getContent();
    
        if( selected ){
          //If text is selected when button is clicked
          //Wrap shortcode around it.
          content =  '[cpt_testimonial id="'+selected+'"]';
        }else{
          content =  '[cpt_testimonial id=""]';
        }
    
        tinymce.execCommand('mceInsertContent', false, content);
      });
      // Register buttons - trigger above command when clicked
      ed.addButton('wpse72394_cpt_button', {title : 'Add Button', cmd : 'wpse72394_add_cpt_button_shortcode', image: url + '/img/subscribe.png' });
      ed.addButton('wpse72394_cpt_testimonial', {title : 'Add Testimonials', cmd : 'wpse72394_add_cpt_testimonials_shortcode', image: url + '/img/contact.png' });
    },
  });
  
  // Register our TinyMCE plugin
  // first parameter is the button ID1
  // second parameter must match the first parameter of the tinymce.create() function above
  tinymce.PluginManager.add('wpse72394_cpt_button', tinymce.plugins.wpse72394_plugin);
  tinymce.PluginManager.add('wpse72394_cpt_testimonial', tinymce.plugins.wpse72394_plugin);
});
