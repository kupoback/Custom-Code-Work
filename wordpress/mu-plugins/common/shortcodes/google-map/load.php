<?php
/**
 *  Custom Shortcode: Google Map
 *
 *  @package DBDB_Shortcode_Collapse
 *
 *  @license     http://www.gnu.org/licenses/gpl-2.0.txt GPL-2.0+
 *  @version     1.0.0
 *
 *  Plugin Name: Shortcode: Google Map
 *  Plugin URI:
 *  Description: A shortcode for displaying a styled google map for site.
 *  Version:     1.0.0
 *  Author:      
 *  Author URI:  
 *  Text Domain:
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
function cpt_shortcode_gmap_init() {
  add_shortcode( 'gmap', 'cpt_shortcode_gmap' );
  add_shortcode( 'add_gmap', 'cpt_shortcode_add_gmap' );
}
add_action( 'init', 'cpt_shortcode_gmap_init' );


/**
 *  Shortcode: gmap
 *
 *  Displays Name, Job Title, phone, email
 *
 *  @since 1.0.0
 */
function cpt_shortcode_gmap( $atts, $content = null ){
  
  $atts = shortcode_atts(
    array(
      'id'         => 0,
      'output'     => 'OBJECT',
      'filter'     => 'raw',
      'mailto'     => 1,
      'show_thumb' => 0
    ),
    $atts,
    'gmap'
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
  
  $post_args = apply_filters( 'dbdb_gmap_shortcode_args', $post_args );
  
  $_post = get_post( $post_args['post'], $post_args['output'], $post_args['filter'] );
  
  if ( ! is_null( $_post ) ) :
    
    $fields = ( function_exists( 'get_fields' ) ) ? get_fields( $id ) : array() ;
    $map_api_key         = ( ! empty( $fields['map_api_key'] ) ) ? $fields['map_api_key'] : 'AIzaSyBOK9aLvwRsGwQckl19L4xBtcFpSJZQaSs' ;
    $map_latitude        = ( ! empty( $fields['map_latitude'] ) ) ? $fields['map_latitude'] : '41.852221' ;
    $map_longitude       = ( ! empty( $fields['map_longitude'] ) ) ? $fields['map_longitude'] : '-88.154833' ;
    $map_height       = ( ! empty( $fields['map_height'] ) ) ? $fields['map_height'] : '400' ;
    $map_zoom       = ( ! empty( $fields['map_zoom'] ) ) ? $fields['map_zoom'] : '12' ;
  
  ob_start();
    // Content to spit out
    ?>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo $map_api_key;?>&callback=initMap">
    </script>
    <script type="text/javascript">
      function initMap() {
        var latLng = {lat: <?php echo $map_latitude; ?>, lng: <?php echo $map_longitude; ?>};
        var mZoom = parseInt(<?php echo $map_zoom; ?>);
        var map = new google.maps.Map(document.getElementById('gmap'), {
          zoom: mZoom,
          center: latLng,
          streetViewControl: false, // hide the yellow Street View pegman
          scaleControl: true, // allow users to zoom the Google Map
          maxZoom: 20,
          minZoom: 8,
          scrollwheel: false,
        });
        map.panBy(0, 0);
        var iconBase = '/wp-content/themes/division/assets/img/';
        var marker = new google.maps.Marker({
          position: latLng,
          map: map,
          icon: iconBase + 'fd_map_marker.png'
        });
      }
    </script>
  
    <div id="gmap" class="internal-gmap" style="width: 100%; height: <?php echo $map_height; ?>px;"></div>
    
    <?php
    $content = ob_get_clean();
  
  endif;
  
  wp_reset_postdata();
  
  return apply_filters( 'cpt_shortcode_gmap_content', $content );
  
}


/**
 *  Shortcode: add_gmap
 *
 *  Displays a list of gmap
 *
 *  @since 1.0.0
 */
function cpt_shortcode_add_gmap_content( $atts, $content = null ){
  
  $atts = shortcode_atts(
    array(
      'ids' => '',
    ),
    $atts,
    'add_gmap'
  );
  
  // if there are no IDs
  if( empty( $atts['ids'] ) ){
    return $content;
  }
  
  $ids = explode(',', $atts['ids'] );
  
  if ( ! empty( $ids )) :
    
    ob_start();
    ?>
    
    <div class="gmap-list clearfix">
      <?php foreach( $ids as $id ) : ?>
        <?php echo do_shortcode( '[gmap id="' . $id . '"]' ); ?>
      <?php endforeach; ?>
    </div>
    
    <?php
    $content = ob_get_clean();
  
  endif;
  
  return apply_filters( 'cpt_shortcode_add_gmap_content', $content );
  
}


/**
 *  Add contextual help tab to Editor Screen
 *
 *  @since 1.0.0
 */
function cpt_shortcode_gmap_help_tab() {
  
  global $pagenow, $post, $post_type;
  
  if( null === $post_type ) {
    $post_type = ( isset($_GET['post_type']) && !empty($_GET['post_type']) ) ? $_GET['post_type'] : '' ;
  }
  
  if ('post.php' == $pagenow  && (isset($_GET['action'])&& 'edit' == $_GET['action']) ) {
    $postid = ($post && '' != $post->ID ) ? $post->ID : $_GET['post'];
    $post_id_text = '<p>' . __('Your post id is: <strong>' . $postid . '</strong>  <br /><br />This number should match the number in the URL above where it says &#8220;<code>post=###</code>&#8221;.') . '</p>';
    get_current_screen()->add_help_tab( array(
      'id'      => 'your-post-id',
      'title'   => __('Post ID'),
      'content' => $post_id_text,
    ) );
    
    $params = array(
      'id' => 'The ID of the content you want to display.',
    );
    
    $param_string = '<ul>';
    foreach( $params as $param => $text ){
      $param_string .= sprintf('<li><code>%s</code>: %s</li>', $param, $text);
    }
    $param_string .= '</ul>';
    
    $short_text = '<p>To embed this post on a page, copy/post the following shortcode: <code>[gmap id="'.$postid.'"]</code></p>';
    $short_text .= sprintf( '<p>The available parameters for the shortcode are: </p>%s', $param_string );
    
    get_current_screen()->add_help_tab( array(
      'id'      => 'gmap-shortcode',
      'title'   => __('Shortcode'),
      'content' => $short_text,
    ) );
  }
  
}
add_action('load-post.php', 'cpt_shortcode_gmap_help_tab');
add_action('load-post-new.php', 'cpt_shortcode_gmap_help_tab');
