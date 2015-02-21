<?php
/**
 * Single Product Up-Sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$upsells = $product->get_upsells();

if ( sizeof( $upsells ) == 0 ) return;

$meta_query = WC()->query->get_meta_query();

$args = array(
	'post_type'           => 'product',
	'ignore_sticky_posts' => 1,
	'no_found_rows'       => 1,
	'posts_per_page'      => $posts_per_page,
	'orderby'             => $orderby,
	'post__in'            => $upsells,
	'post__not_in'        => array( $product->id ),
	'meta_query'          => $meta_query
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

if ( $products->have_posts() ) : ?>

	<div class="upsells products row">
		<h4><?php _e( 'Up sells', 'woocommerce' ); ?></h4>

			<?php while ( $products->have_posts() ) : $products->the_post(); 
				$image 				= wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );	 	
			?>
				<div class="large-12 columns">
					<div class="panel" data-equalizer-watch>
						<h5><?php the_title(); ?></h5>
							<a href="<?php the_permalink(); ?>"><img src="<?php echo get_image_woo($post->ID); ?>" title="<?php the_title(); ?> image"></a>
							<p> <?php 

							$string = strip_tags( $post->post_content);

							if (strlen($string) <=100) {
							  echo $string;
							} else {
							  echo substr($string, 0, 100) . '...';
							}

							?>
							<?php  wc_get_template( 'loop/price.php' ); ?>
							<?php woocommerce_template_single_add_to_cart(); ?>

							
					</div>
				</div>
			<?php endwhile; // end of the loop. ?>

	</div>

<?php endif;

wp_reset_postdata();
