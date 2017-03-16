/**
 * This is used for the Customizer to generate
 * a live preview.
 * Created by nickmak on 3/16/17.
 */

( function( $ ) {
  
  // Get the setting that we need for Live Preview
  wp.customize( 'np_stylesheet_selector', function( value ) {
    // Bind that value to a function
    value.bind( function( newval ) {
      // Based on the option selected from the dropdown we decide which stylesheet to showcase
      if ( newval == 'color_1' ) {
        // If the stylesheet was pre-loaded by `color_2`, then we remove it and add `color_1` option
        if ( $( 'link[href="/wp-content/themes/navypier/css/color-rework-2017-2.css"]' ) == true ) {
          $( 'link[href="/wp-content/themes/navypier/css/color-rework-2017-2.css"]' ).attr( 'href', '/wp-content/themes/navypier/css/color-rework-2017-1.css');
        }
        // Otherwise, we just load `color_1`
        else {
          $( 'head' ).append( '<link rel="stylesheet" class="swap" type="text/css" href="/wp-content/themes/navypier/css/color-rework-2017-1.css">' );
        }
      }
      else if ( newval == 'color_2') {
        // If the stylesheet was pre-loaded by `color_1`, then we remove it and add `color_2` option
        if ( $( 'link[href="/wp-content/themes/navypier/css/color-rework-2017-1.css"]' ) == true ) {
          $( 'link[href="/wp-content/themes/navypier/css/color-rework-2017-1.css"]' ).attr( 'href', '/wp-content/themes/navypier/css/color-rework-2017-2.css');
        }
        // Otherwise we just load `color_2`
        else {
          $( 'head' ).append( '<link rel="stylesheet" class="swap" type="text/css" href="/wp-content/themes/navypier/css/color-rework-2017-2.css">' );
        }
      }
    });
  });
  
})(jQuery)
