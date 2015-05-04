<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product;

?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?> ng-controller="singleprodpagecontroller">
	<div class="row" ng-init="postid = '<?php echo $product->id; ?>' ">
		<?php
			/**
			 * woocommerce_before_single_product hook
			 *
			 * @hooked wc_print_notices - 10
			 */
			 do_action( 'woocommerce_before_single_product' );

			 if ( post_password_required() ) {
			 	echo get_the_password_form();
			 	return;
			 }
			?>

			<div class="large-9 columns">
				<div class="row">
					<div class="large-12 columns small-12">
						<?php woocommerce_template_single_title(); ?>
						<hr>
					</div>
				</div>
				<div class="row">
					<div class="large-6 columns small-12">
						<?php woocommerce_show_product_images(); ?>
					</div>
					<div class="large-6 columns small-12">
						<div class="row">
							<div class="large-12 columns">
								<?php woocommerce_template_single_price(); ?>
								<p>	<?php woocommerce_template_single_rating(); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<?php if ( $product->is_in_stock() ){ ?>
								<h4 >Add to cart:</h4>
								<?php } ?>
								<?php woocommerce_template_single_add_to_cart(); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns ">
						<hr/>
							<?php the_content(); ?>
						<hr/>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns">
						<?php get_template_part('woocommerce/single-product/tabs/additional-information'); ?>
					</div>
				</div>
			</div>

		<div class="large-3 columns">
			<div class="row">
				<div class="large-12 columns">
					<?php dynamic_sidebar("product-above-upsells"); ?>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<?php woocommerce_upsell_display(); ?>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<?php dynamic_sidebar("product-below-upsells"); ?>
				</div>
			</div>
			<div class="row">
				<div class="large-12 columns">
					<?php woocommerce_output_related_products(); ?>
				</div>
			</div>
		</div>

		<meta itemprop="url" content="<?php the_permalink(); ?>" />


		<?php do_action( 'woocommerce_after_single_product' ); ?>
	</div><!-- #product-<?php the_ID(); ?> -->
</div>
