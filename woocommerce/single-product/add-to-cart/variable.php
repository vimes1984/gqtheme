<?php
/**
 * Variable product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $post;
$availability      = $product->get_availability();

?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

<form class="variations_form cart" method="post" action="<?php echo get_permalink(); ?>" enctype='multipart/form-data' data-product_id="<?php echo $post->ID; ?>" data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
	<?php if ( ! empty( $available_variations ) ) : ?>
		<table class="variations_new" cellspacing="0">
			<tbody>
				<?php $loop = 0; foreach ( $attributes as $name => $options ) : $loop++; ?>
					<tr>
						<td class="label"><label for="<?php echo sanitize_title($name); ?>"><?php echo wc_attribute_label( $name ); ?></label></td>
						<td class="value_test">
							<select id="<?php echo esc_attr( sanitize_title( $name ) ); ?>" name="attribute_<?php echo sanitize_title( $name ); ?>" ng-model="currentvariation.vartype" ng-change="changevar('attribute_<?php echo sanitize_title( $name ); ?>')" >




							<option value=""><?php echo __( 'Choose an option', 'woocommerce' ) ?>&hellip;</option>
							<?php
								if ( is_array( $options ) ) {

									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) ) {
										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];
									} elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) ) {
										$selected_value = $selected_attributes[ sanitize_title( $name ) ];
									} else {
										$selected_value = '';
									}

									// Get terms if this is a taxonomy - ordered
									if ( taxonomy_exists( sanitize_title( $name ) ) ) {

										$orderby = wc_attribute_orderby( sanitize_title( $name ) );

										switch ( $orderby ) {
											case 'name' :
												$args = array( 'orderby' => 'name', 'hide_empty' => false, 'menu_order' => false );
											break;
											case 'id' :
												$args = array( 'orderby' => 'id', 'order' => 'ASC', 'menu_order' => false, 'hide_empty' => false );
											break;
											case 'menu_order' :
												$args = array( 'menu_order' => 'ASC', 'hide_empty' => false );
											break;
										}

										$terms = get_terms( sanitize_title( $name ), $args );

										foreach ( $terms as $term ) {
											if ( ! in_array( $term->slug, $options ) )
												continue;

											echo '<option value="' . esc_attr( $term->slug ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $term->slug ), false ) . '>' . apply_filters( 'woocommerce_variation_option_name', $term->name ) . '</option>';
										}
									} else {

										foreach ( $options as $option ) {
											echo '<option value="' . esc_attr( sanitize_title( $option ) ) . '" ' . selected( sanitize_title( $selected_value ), sanitize_title( $option ), false ) . '>' . esc_html( apply_filters( 'woocommerce_variation_option_name', $option ) ) . '</option>';
										}

									}
								}
							?>
						</select> <?php
							if ( sizeof( $attributes ) == $loop )
								echo '<p class="restall"  ng-click="resetvars()">' . __( 'Clear selection', 'woocommerce' ) . '</p>';
						?></td>
					</tr>
		        <?php endforeach;?>
			</tbody>
		</table>

		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

		<div class="single_variation_wrap" ng-show="currentvariation.vartype != '' ">
			<?php do_action( 'woocommerce_before_single_variation' ); ?>

			<div class="variations_button" >
			<table class="variations_button_qty" cellspacing="0" ng-hide="currentvariation.var.stock_text == 'Sold out'">
						<tbody>
								<tr>
									<td class="label"><label for="quantity">Qty</label></td>
									<td class="value">
										<?php woocommerce_quantity_input(); ?>
									</td>
								</tr>
					  </tbody>
					</table>
				<div class="row">
					<div class="large-3 columns">
						<p>Availability:</p>
					</div>
					<div class="large-9 columns">
						<p ng-bind-html="to_trusted(currentvariation.var.stock_text)"></p>
					</div>
				</div>
				<div class="row addtocartwrap">
					<div class="large-6 columns">
						<?php echo do_shortcode('[yith_wcwl_add_to_wishlist]'); ?>
					</div>
					<div class="large-6 columns" ng-hide="currentvariation.var.stock_text == 'Sold out'">
						<button type="submit" class="single_add_to_cart_button button alt"><?php echo $product->single_add_to_cart_text(); ?></button>
					</div>
				</div>

			</div>

			<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>" />
			<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>" />
			<input type="hidden" name="variation_id" value="{{currentvariation.var.variation_id}}" />

			<?php do_action( 'woocommerce_after_single_variation' ); ?>
		</div>

		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

	<?php else : ?>

		<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php endif; ?>

</form>

<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
