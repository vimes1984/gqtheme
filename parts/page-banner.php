<header id="banner-hedaer" class="header-slider" role="banner">
		<?php if (is_product_category() ){ ?>
			<header id="homepage-hero" role="banner">
				<div class="row">
					<div class="small-12 medium-9 columns">

					</div>
					<div class="medium-3   hide-for-small columns">
						<!--<img  data-cfsrc="<?php echo( get_header_image() ); ?>" src="<?php echo( get_header_image() ); ?>" alt="<?php echo( get_bloginfo( 'title' ) ); ?>" />-->
					</div>
				</div>
			</header>
			<!--<div class="seperator"></div>-->
			<?php }elseif (is_shop()) { ?>
			<header id="homepage-hero" role="banner">
				<div class="row">
					<div class="small-12 medium-9 columns">
						<div class="row">
							<div class="large-12 columns">
								<?php woocommerce_category_title(); ?>
							</div>
							<div class="large-10 small-centered columns">
								<?php woocommerce_category_image(); ?>
							</div>
						</div>
					</div>
					<div class="small-12 medium-3   hide-for-small columns">
						<img class="centered" data-cfsrc="http://www.gqblends.com/wp-content/uploads/2015/01/cropped-GQTobaccos-logo-409x309-trans-bg.png" alt="Foundation Yeti" src="http://www.gqblends.com/wp-content/uploads/2015/01/cropped-GQTobaccos-logo-409x309-trans-bg.png">
					</div>
				</div>
			</header>
			<?php } ?>
</header>