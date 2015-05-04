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

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<div class="large-12 columns">
					<div class="" data-equalizer-watch>
						<h5><?php the_title(); ?></h5>
							<a href="<?php the_permalink(); ?>"><img src="<?php echo get_image_woo($post->ID); ?>" title="<?php the_title(); ?> image"></a>
							<?php  wc_get_template( 'loop/price.php' ); ?>

							<?php if ( $product->is_in_stock() ){ ?>

								<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

								<form class="cart" method="post" enctype='multipart/form-data' action="<?php echo get_permalink( $product->id ); ?>" ng-cloak>
								 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

								 	<?php
								 		if ( ! $product->is_sold_individually() )
								 			woocommerce_quantity_input( array(
								 				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
								 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
								 			) );
								 	?>

								 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $products->post->ID ); ?>" />
									<div class="row addtocartwrap">
										<div class="large-12 columns">
											<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
										</div>
									</div>

									<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
								</form>

								<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

							<?php }else{ ?>
								<h2>No in stock</h2>
							<?php }; ?>

					</div>
				</div>
				<hr/>
			<?php endwhile; // end of the loop. ?>

	</div>

<?php endif;

wp_reset_postdata();
