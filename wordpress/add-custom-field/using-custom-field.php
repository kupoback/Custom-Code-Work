<?php
// Call to the meta
$add_to_cal = get_post_meta( get_the_ID(), '_add_to_calendar' );

// If the field is checked, then show what you need, otherwise, skip it.
<?php if ( $add_to_cal[0] == true ) : ?>
  <p>This is true, here is your content.</p>
<?php endif; ?>
