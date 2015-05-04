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
		$catslug 							= woocommerce_return_cat_slug();
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
					<div ng-bind-html="to_trusted(errormsg)"></div>
					<span us-spinner spinner-key="spinner-1" spinner-start-active="true" style="position: fixed;display: block;top: 50%;left: 50%;right: 50%;"></span>
					<div class="products row" isotope-container>
							<div ng-repeat="product in shoploop | filter:search |  minmaxfilter:userMinRing:userMaxRing |  minmaxfilterlength:userMinLength:userMaxLength " isotope-item class="{{product.classes}}" ng-cloak>
									<div class="row">
										<div class="large-9 columns">
											<h4 class="title"><a ng-href="{{product.permalink}}" class="">{{product.product_title}}</a></h3>
										</div>
										<div class="large-3 columns">

											<h4 class="price_title" ng-if="product.price.type == 'variable'">From: &pound;{{product.price.price}}</h4>
											<h4 class="price_title" ng-if="product.price.type == 'tobbaco_sample'">From: &pound;{{product.price.price}}</h4>
											<h4 class="price_title" ng-if="product.price.type == 'simple'">&pound;{{product.price.price}}</h4>
										</div>
									</div>
									<div class="row" ng-if="product.wpcf_show_attributes === 'yes'">
										<div class="large-4 columns">
											<a ng-href="{{product.permalink}}" class="addcart expand"><img src-ondemand="{{product.prod_img}}" alt="{{product.product_title}}"></a>
										</div>
										<div class="large-4 small-6 columns">
											<section ng-repeat="productatts in product.product_attnew" ng-if="$index <= 4" class="shop_attributes">
												<p><span>{{productatts.parentname}}</span> - <span ng-bind-html="to_trusted(productatts.name)"></span></p>
											</section>
										</div>
										<div class="large-4 small-6 columns">
												<section ng-repeat="productatts in product.product_attnew" ng-if="limitfunctyion($index)" class="shop_attributes">
													<p><span>{{productatts.parentname}}</span> - <span ng-bind-html="to_trusted(productatts.name)"></span></p>
												</section>
										</div>
									</div>
									<div class="row" ng-if="product.wpcf_show_attributes === '0' || product.wpcf_show_attributes === 'no'">
										<div class="large-12 columns">
											<img src-ondemand="{{product.prod_img}}" alt="{{product.product_title}}">
										</div>
									</div>
									<div class="row">
										<div class="large-10 columns">
										</div>
										<div class="large-2 columns">
											<a ng-href="{{product.permalink}}" class="addcart expand">Read More</a>
										</div>
									</div>
									<hr/>
								</div>
					</div>
				</div>
				<div id="rightwidgswrap" class="large-3 columns">
					<input type="text" placeholder="Search..." ng-model="search.product_title" id="searchboxshop">

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
