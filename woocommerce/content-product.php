<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;
?>

<div <?php post_class( $classes ); ?>>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>


		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			//do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<h3><?php the_title(); ?><?php  wc_get_template( 'loop/price.php' ); ?></h3>
		<div class="loop-left-col">
			<?php echo woocommerce_get_product_thumbnail(); ?>
		</div>
		<div class="loop-right-col">
			<p> <?php 

			$string = strip_tags( $post->post_content);

			if (strlen($string) <=400) {
			  echo $string;
			} else {
			  echo substr($string, 0, 400) . '...';
			}

			?><br><a href="<?php the_permalink(); ?>">Read More</a></p>
			<div class="float-right">
				
			</div>
		</div>

	<?php 
	/**
	 *
	 */
	    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		do_action( 'woocommerce_after_shop_loop_item' ); 
	?>

</div>