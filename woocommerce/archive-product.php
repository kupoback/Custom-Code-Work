<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
    <?php

    ?>
		<?php
			/**
			 * woocommerce_archive_description hook
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>

		<?php if ( have_posts() ) : ?>
            <?php
            // Get Data to detect whether or not is Sub Category
            $parent_cat_ID = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) )->term_id;
            $args = array(
                'hierarchical'      =>  1,
                'show_option_none'  =>  '',
                'hide_empty'        =>  0,
                'parent'            =>  $parent_cat_ID,
                'taxonomy'          =>  'product_cat'
            );
            $sub_cats = get_categories( $args );
            $num_parent_cats = count($sub_cats);
            ?>


            <?php if ( $num_parent_cats > 0 ): ?>

					<?php
						foreach( $sub_cats as $sub_cat) { ?>
							<div class="sub-cat-container">
								<div class="title-wrapper">
									<h2><?php echo $sub_cat->name; ?></h2>
								</div>
								<?php
								$args_products = array(
													'post_type'			=> 'product',
													'posts_per_page'	=> 4,
													'post_status'		=> 'publish',
													'meta_query'        => array(
																				array(
																					'key'       => '_visibility',
																					'value'     => array('catalog', 'visible'),
																					'compare'	=> 'IN'
																				)
																			),
													'tax_query'         => array(
																				array(
																					'taxonomy'      => 'product_cat',
																					'field' 		=> 'term_id', //This is optional, as it defaults to 'term_id'
																					'terms'         => $sub_cat->term_id,
																					'operator'      => 'IN' // Possible values are 'IN', 'NOT IN', 'AND'.
																				)
																			)
												);
								$products = get_posts( $args_products );

								$sale_price = get_post_meta( get_the_ID(), '_price', true);
								$x = 0;
								foreach ( $products as $product ) { ?>
									<div class="sub-cat-box num-<?php echo $x; ?>">
										<a class="image-container" href="<?php echo get_permalink($product->ID); ?>">
											<?php echo get_the_post_thumbnail($product->ID, 'medium', array( 'class' => 'img-responsive' )); ?>
										</a>
										<a href="<?php echo get_permalink($product->ID); ?>" class="view btn">
											<h3>View</h3>
										</a>
										<a class="title-price" href="<?php echo get_permalink($product->ID); ?>">
											<h3><?php echo $product->post_title; ?></h3>
											<p><?php echo $sale_price; ?></p>
										</a>
									</div>
								<?php $x++; }
								?>
								<div class="view-all-container">
									<a href="<?php echo get_category_link($sub_cat); ?>" class="view-all-link"><h4>View All <i class="fa fa-chevron-right"></i></h4></a>
								</div>
							</div>
					<?php } ?>


            <?php elseif ( $num_parent_cats == 0 ): ?>
			<?php
			/**
			 * woocommerce_before_shop_loop hook
			 *
			 * @hooked woocommerce_result_count - 20
			 * @hooked woocommerce_catalog_ordering - 30
			 */
			do_action( 'woocommerce_before_shop_loop' );
			?>
			<?php
                // If no subcat
                woocommerce_product_loop_start(); ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
            <?php endif; ?>
			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>

<?php get_footer( 'shop' ); ?>
