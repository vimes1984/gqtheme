<?php
	global $woocommerce;
	$cart_url = $woocommerce->cart->get_cart_url();
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
	$checkout_url = $woocommerce->cart->get_checkout_url();
?>

<div class="fixed contain-to-grid  hide-for-medium-down" id="fixedtopbar" ng-controller="menucontroll">
  	<nav class="top-bar" data-topbar role="navigation">
    	<section class="top-bar-section large-6 columns">
	    	<?php foundationPress_top_bar_l(); ?>
		</section>
	    <section class="large-6 columns">
	        	<div class="row">
					<div class="large-3 columns">
						<?php
							if ( $myaccount_page_id ) {
								$myaccount_page_url = get_permalink( $myaccount_page_id );
						?>
							<a href="<?php echo $myaccount_page_url;  ?>"><i class="fi-home large"></i> <?php _e('Account', 'theme settings'); ?></a>
						<?php }?>
					</div>
					<div class="large-6 columns">
						<a href="<?php echo $cart_url; ?>"><i class="fi-shopping-cart large"></i> <?php _e('Cart', 'theme settings'); ?> <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
					</div>
					<div class="large-3 columns">
						<a href="<?php echo $checkout_url; ?>"> Checkout</a>
					</div>
				</div>
	    </section>
	</nav>
</div>
<?php
/*
<div class="top-bar-container hide-for-medium-down fixed" role="navigation">
	<nav class="top-bar row" data-topbar="">

	</nav>
</div>
*/
