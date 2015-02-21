<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $post, $woocommerce ;

if ( empty( $product ) || ! $product->exists() ) {
	return;
}

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;


if ( $products->have_posts() ) : ?>

	<div class="related products row" data-equalizer>

		<h><?php _e( 'Related Products', 'woocommerce' ); ?></h>


			<?php while ( $products->have_posts() ) : $products->the_post(); 

			?>
			
				<div class="large-12 columns">
					<div class="panel" data-equalizer-watch>
						<h3><?php the_title(); ?></h3>
							<a href="<?php the_permalink(); ?>"><img src="<?php echo get_image_woo($post->ID); ?>" title="<?php the_title(); ?> image"></a>
							<p> <?php 

							$string = strip_tags( $post->post_content);

							if (strlen($string) <=100) {
							  echo $string;
							} else {
							  echo substr($string, 0, 100) . '...';
							}

							?></p>
							<?php  wc_get_template( 'loop/price.php' ); ?>
							<p><a href="<?php the_permalink(); ?>" class="button expand">Read More</a></p>
					</div>
				</div>
			
			<?php endwhile; // end of the loop. ?>

	</div>

<?php endif;

wp_reset_postdata();
