<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();


$i = 0;
$left  = '<div class="large-6 columns">';
$right = '<div class="large-6 columns">';

foreach ($attributes as $attribute) {
	if ( $attribute['is_taxonomy'] ) {

		$values = 	wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
		$att 		=  	apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

	} else {

		// Convert pipes to commas and display values
		$values = 	array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
		$att		=  	apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );

	}
    if ($i++ % 2 == 0) {

        $left  .= '<div class="item"><p><span><strong>' . wc_attribute_label( $attribute['name'] ) . ':</strong> </span><span>'. implode( ', ', $values ).'</span></p></div>';
    } else {
				$right .= '<div class="item"><p><span><strong>' . wc_attribute_label( $attribute['name'] ) . ':</strong> </span><span>'. implode( ', ', $values ).'</span></p></div>';
    }
}

$left  .= '</div>';
$right .= '</div>';



?>
<div class="row">
	<?php echo $left; ?>
	<?php echo $right; ?>
</div>
