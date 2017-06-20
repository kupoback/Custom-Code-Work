	<?php
  // Parse the URI which ignores the domain
  $check = $_SERVER["REQUEST_URI"];
  
  // Used for the Tribe Events to get their categories.
	$terms = get_terms( Tribe__Events__Main::TAXONOMY, array( 'hide_empty' => 0 ) );
	if ($terms ) :
		echo '<div class="categories">';
    // Check the URI for the words 'category' and if it exists, then ignore this statement
    if ( strpos( $check, 'category' ) == false ) :
      echo '<span><a class="all cat current" href="/events/">' . __( 'All Events', 'firkiosk' ) . '</a></span>';
    else :
      echo '<span><a class="all cat" href="/events/">' . __( 'All Events', 'firkiosk' ) . '</a></span>';
    endif;
		foreach ( $terms as $t ) :
      // Check the URI to see if the slug matches. If so, give it a current class otherwise ignore.
      if (strpos( $check, $t->slug ) ) :
			  echo '<span><a class="' . $t->slug . ' cat current" href="/events/category/' . $t->slug . '">' . __( $t->name, 'firkiosk' ) . '</a></span>';
		  else :
			  echo '<span><a class="' . $t->slug . ' cat" href="/events/category/' . $t->slug . '">' . __( $t->name, 'firkiosk' ) . '</a></span>';
		  endif;
		endforeach;
	endif;
	?>
