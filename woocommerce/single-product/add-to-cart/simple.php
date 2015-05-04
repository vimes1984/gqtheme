<?php
/**
 * Simple product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;

if ( ! $product->is_purchasable() ) return;
?>

<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

?>

<?php if ( $product->is_in_stock() ){ ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data' action="<?php echo get_permalink( ); ?>" ng-cloak>
	 	<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

	 	<?php
	 		if ( ! $product->is_sold_individually() )
	 			woocommerce_quantity_input( array(
	 				'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
	 			) );
	 	?>

	 	<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>" />
			<div class="row">
				<div class="large-4 columns">
					<p>Availability:</p>
				</div>
				<div class="large-8 columns">
					<p ng-bind-html="to_trusted(availtext)"></p>
					
				</div>
			</div>
		<div class="row addtocartwrap">
			<div class="large-6 columns">
				<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
			</div>
			<div class="large-6 columns">
				<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
			</div>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php }else{ ?>
	<h2>{{availtext}}</h2>
<?php }; ?>
