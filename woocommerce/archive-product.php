<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

		get_header( 'shop' );
		global $wp_query;
		
		//var_dump($wp_query);
		$catslug 				= woocommerce_return_cat_slug();
		$i = 0; 
?>
<div ng-controller="shoppagecontroller">

	<div id="shoploopwrap" class="row" ng-init="category = '<?php echo $catslug; ?>'">

				<div id="shopcontent" class="large-9 columns">
					<div class="row">
						<div class="large-12 columns">
							<h3 class='catname'><?php woocommerce_category_title(); ?></h3>
							<?php woocommerce_category_image(); ?>
							<?php woocommerce_category_description(); ?>
						</div>
					</div>
					<div class="row">
						<div class="large-12 columns">
							<?php woocommerce_get_cat_children_links(); ?>
						</div>
					</div>
					<span us-spinner spinner-key="spinner-1" spinner-start-active="true" style="position: relative;width: 100%;display: block;"></span>
					<div class="products row" isotope-container>
							<div ng-repeat="product in shoploop | filter:search |  minmaxfilter:userMinRing:userMaxRing |  minmaxfilterlength:userMinLength:userMaxLength " isotope-item class="{{product.classes}}" ng-cloak>
								<div class="panel">
									<div class="row">
										<div class="large-9 columns">
											<h4 class="title">{{product.post_title}}</h3>
										</div>
										<div class="large-3 columns">

											<h4 ng-show="product.price.type == 'variable'">From: &pound; {{product.price.price}}</h3>
											<h4 ng-show="product.price.type == 'tobbaco_sample'">From: &pound; {{product.price.price}}</h3>
											<h4 ng-show="product.price.type == 'simple'">&pound; {{product.price.price}}</h3>
										</div>
									</div>
									<div class="row" ng-show="product.product_meta.wpcf_show_attributes === 'yes'">
										<div class="large-4 columns">
											<img ng-src="{{product.prod_img}}" alt="{{product.post_title}}">
										</div>
										<div class="large-4 columns">
											<table class="shop_attributes">
												<tr ng-repeat="productatts in product.product_att" ng-show="$index <= 3">
													<td>{{productatts.name}}</td>
													<td  ng-bind-html="to_trusted(productatts.value)"></td>
												</tr>
											</table>
										</div>
										<div class="large-4 columns">
											<table class="shop_attributes">
												<tr ng-repeat="productatts in product.product_att" ng-show="limitfunctyion($index)">
													<td>{{productatts.name}}</td>
													<td  ng-bind-html="to_trusted(productatts.value)"></td>
												</tr>
											</table>
										</div>										
									</div>
									<div class="row" ng-show="product.product_meta.wpcf_show_attributes === '0' || product.product_meta.wpcf_show_attributes === 'no'">
										<div class="large-12 columns">
											<img ng-src="{{product.prod_img}}" alt="{{product.post_title}}">
										</div>									
									</div>
									<div class="row">
										<div class="large-12 columns">
											<a ng-href="{{product.permalink}}" class="addcart button expand">Read More</a>						
										</div>
									</div>
								</div>
							</div>
					</div>
				</div>
				<div id="rightwidgswrap" class="large-3 columns">
					<input type="text" placeholder="Search..." ng-model="search.post_title" id="searchboxshop">	

					<div id="rightcats_top">
						<?php dynamic_sidebar("right-cart-top"); ?>
					</div>					
					<div id="rightcats">
						<?php get_clear(); ?>
						<?php display_prod_atts_ring(); ?>
						<?php display_prod_atts_length(); ?>
						<?php display_prod_atts(); ?>
						<?php //dynamic_sidebar("right-middle"); ?>
					</div>
					<div id="rightcats_bottom">
						<?php dynamic_sidebar("right-bottom"); ?>
					</div>				
				</div>
	</div>
</div>
<?php get_footer( 'shop' ); ?>