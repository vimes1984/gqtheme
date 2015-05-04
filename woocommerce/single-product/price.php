<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer" ng-cloak>
	<div ng-if="singledata.price.type == 'variable'">
		<div ng-if="currentvariation.vartype == ''">
			<h1 class="price">From &pound;{{price}}</h1>
		</div>
		<div ng-if="currentvariation.vartype != ''">

			<div ng-if="salesprice != ''">
				<h1 class="price"><strike class="small">&pound;{{salesprice}}</strike> &pound;{{price}} test</h1>
			</div>
			<div ng-if="salesprice == ''">
				<h1 class="price">&pound;{{price}}</h1>
			</div>

		</div>
	</div>
	<div ng-if="singledata.price.type == 'simple'">
		<div ng-if="singledata.product_meta._sale_price === ''" >
			<h1 class="price">&pound;{{price}}</h1>
		</div>
		<div ng-if="singledata.product_meta._sale_price != ''" >
			<h1 class="price"><strike class="small">&pound;{{price}}</strike> &pound;{{singledata.product_meta._sale_price}}</h1>
		</div>
	</div>
	<div ng-if="singledata.price.type == 'default'">
		<div ng-if="singledata.product_meta._sale_price === ''" >
			<h1 class="price">&pound;{{price}}</h1>
		</div>
		<div ng-if="singledata.product_meta._sale_price != ''" >
			<h1 class="price"><strike class="small">&pound;{{price}}</strike> &pound;{{singledata.product_meta._sale_price}}</h1>
		</div>
	</div>
	<meta itemprop="price" content="<?php echo $product->get_price(); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
</div>
