<?php 
// Basic modulus loop that I have needed to use a few times. ?>
<?php $i = 1; ?>
<?php $numItems = count( $post_ids ); ?>
<?php if ( $team_query->have_posts() ) :  while ( $team_query->have_posts() ) :  $team_query->the_post(); ?>
		  
  <?php if ( $i == 1 ) : ?>
    <div class="row">
  <?php endif; ?>

  <?php if ( ($numItems ) == $i )  : ?>
    </div><!-- ./last-row -->
  <?php elseif ( ( $i % $posts_per_page ) == 0 && $i != 1 ) : ?>
    </div><!-- .row --><div class="row">
  <?php endif; ?>
			
<?php $i++; endwhile; endif; ?>
