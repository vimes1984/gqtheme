<?php 
	global $woocommerce;
	$cart_url = $woocommerce->cart->get_cart_url();
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
	$checkout_url = $woocommerce->cart->get_checkout_url();
?>
<div id="toptopbar">
	<div class="row" data-equalizer>
		<div class="large-4 columns" data-equalizer-watch>
			<a href="<?php echo get_site_url(); ?>">
				<img  data-cfsrc="<?php echo( get_header_image() ); ?>" src="<?php echo( get_header_image() ); ?>" alt="<?php echo( get_bloginfo( 'title' ) ); ?>" />
			</a>
		</div>
		<div class="large-8 columns" data-equalizer-watch>
			<div class="row">
				<div class="large-12 columns">
					<?php dynamic_sidebar("post-top-right"); ?>
				</div>
			</div>			
			<div class="row">
				<div class="large-12 columns">
					<img src="http://placehold.it/700x250">
				</div>
			</div>			
			<div class="row">
				<div class="large-12  columns">
					<?php dynamic_sidebar("post-top-left"); ?>
				</div>
			</div>
		</div>
	</div>
</div>