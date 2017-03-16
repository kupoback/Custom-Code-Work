/*
 * Add a checkbox field to Events Post Type within the Publish metabox
 */
function createCustomField() {
  // Get the post ID
  $post_id = get_the_ID();
  
  // Ignore adding this if it is NOT The Events Calendar
  if ( get_post_type($post_id) != 'tribe_events') {
    return;
  }
  
  // Create the meta data to write to the table
  $value = get_post_meta($post_id, '_add_to_calendar', true);
  wp_nonce_field('my_custom_nonce_'.$post_id, 'my_custom_nonce');
  // Add the item to the Publish box
  ?>
  <div class="misc-pub-section misc-pub-section-last">
    <label>Check this box if you wish to have guests add the event to their calendar. Note that longer than day events will create the event in their calendar for everyday.</label><br /><br >
    <label><input type="checkbox" value="1" <?php checked($value, true, true); ?> name="_add_to_calendar" /><?php _e('Add To Your Calendar Icons', 'pmg'); ?></label>
  </div>
  <?php
}

/*
 * Save the checkbox from createCustomField()
 */
function saveCustomField($post_id)
{
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
  }
  
  if (
    !isset($_POST['my_custom_nonce']) ||
    !wp_verify_nonce($_POST['my_custom_nonce'], 'my_custom_nonce_'.$post_id)
  ) {
    return;
  }
  
  if (!current_user_can('edit_post', $post_id)) {
    return;
  }
  if (isset($_POST['_add_to_calendar'])) {
    update_post_meta($post_id, '_add_to_calendar', $_POST['_add_to_calendar']);
  } else {
    delete_post_meta($post_id, '_add_to_calendar');
  }
}

add_action('post_submitbox_misc_actions', createCustomField);
add_action('save_post', saveCustomField);
