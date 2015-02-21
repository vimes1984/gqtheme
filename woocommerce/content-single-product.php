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
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="row">
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
							<div class="large-6 columns">
								<?php woocommerce_template_single_price(); ?>
								<p></p>
								<p>	<?php woocommerce_template_single_rating(); ?></p>
							</div>
						</div>
						<div class="row">
							<div class="large-12 columns">
								<h4>Add to cart:</h4>
								<?php woocommerce_template_single_add_to_cart(); ?>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="large-12 columns panel callout radius">
						<?php the_content(); ?>			
					</div>
				</div>
				<div class="seperator"></div>
				<div class="row">
					<div class="large-12 columns">
						<?php get_template_part('woocommerce/single-product/tabs/additional-information'); ?>
					</div>
				</div>				
			</div>

		<div class="large-3 columns">
			<div class="row">
				<div class="large-12 columns">
					<?php woocommerce_upsell_display(); ?>
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