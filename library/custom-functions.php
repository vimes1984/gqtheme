<?php 
/******************************************************************************\
							Woocommerce
\******************************************************************************/
// Remove woocommerce styles
add_filter( 'woocommerce_enqueue_styles', '__return_false' );
/**
 * Get's Category image for parts/page-banner.php
 */
function woocommerce_category_image() {
    if ( is_product_category() ){
	    global $wp_query;
	    $cat = $wp_query->get_queried_object();
	    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
	    $image = wp_get_attachment_url( $thumbnail_id );
	    if ( $image ) {
		    echo '<img src="' . $image . '" alt="" />';
		}
	}
}

/**
 * Get Cat description for headers
 */
function woocommerce_category_description() {
    if (is_product_category()) {
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        echo "<p>" . $cat->description . "</p>";
    }
}
/**
 * Get Cat description for headers
 */
function woocommerce_category_title() {
    if (is_product_category()) {
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        echo $cat->name;
    }
}

/**
 * Retruns cat as buttons children for isotope loop 
 */
function woocommerce_get_cat_children(){
    if (is_product_category()) {
        global $wp_query;
        $cat 			= $wp_query->get_queried_object();
        $catID 			= $cat->term_id;
        $taxonomy_name 	= "product_cat";
        $termchildren = get_term_children( $catID, $taxonomy_name );
        echo "<div ok-key='filter' opt-kind=''>";
	    echo '<button ok-sel="*" class="button" ng-click="showall()">Show All</button>';
			foreach ( $termchildren as $child ) {
				$term = get_term_by( 'id', $child, $taxonomy_name );
				echo '<button ok-sel=".'.$term->slug.'" class="button filtercats" ng-click="removeallother(\''.$term->slug.'\')" markable>' . $term->name . '</button>';
			}
		echo "</div>";
    }
    if ( is_shop() ){
        global $wp_query;
        $cat 			= $wp_query->get_queried_object();
        $catID 			= $cat->term_id;
		$args = array(
			'type'                     => 'product',
			'child_of'                 => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 0,
			'depth'					   => 1,
			'taxonomy'                 => 'product_cat',
		); 
        $categories = get_categories( $args );
        echo "<div ok-key='filter' opt-kind=''>";
	    echo '<button ok-sel="*" class="button" ng-click="showall()">Show All</button>';
			foreach ( $categories as $child ) {
				if($child->parent == 0){	
					echo '<button ok-sel=".'.$child->slug.'" class="button filtercats" ng-click="removeallother(\''.$child->slug.'\')" markable>' . $child->name . '</button>';
				}
			}
		echo "</div>";

    }    

}
/**
 * Retruns cat as buttons as simple links 
 */
function woocommerce_get_cat_children_links(){
	global $wp_query;

    if (is_product_category()) {
        $cat 			= $wp_query->get_queried_object();
        $catID 			= $cat->term_id;
        $taxonomy_name 	= "product_cat";
		$args_cats = array(
				'parent'	=> $catID,
				'child_of' => $catID,
			   	'taxonomy' => 'product_cat',
			    'hide_empty' => 0,
			    'hierarchical' => true,
			    'depth'  => 1,
		); 

        $categories = get_categories( $args_cats );
        $numItems = count($categories);

        $i = 1;
        $secondcount = 1;
			foreach ( $categories as $child ) {
					$permalink = get_term_link( $child->slug, 'product_cat' );
					if(!is_wp_error($permalink)){
        		
		        		if($i === 1){
		        			echo "<div class='row'>";
		        		}
	        				echo "<div class='columns large-3 columns'> ";
								echo '<a href="'. $permalink .'" class="cat_links">' . $child->name . '</a>';
							echo "</div>";

						if($i === 4 || $secondcount === $numItems ){
	        				echo "</div>";
	        				$i = 1;
						}else{
							$i++;
						}
						$secondcount ++;

					}
				


			}

    }
    if ( is_shop() ){

		$args = array(
			'type'                     => 'product',
			'child_of'                 => 0,
			'orderby'                  => 'name',
			'order'                    => 'ASC',
			'hide_empty'               => 1,
			'hierarchical'             => 0,
			'depth'					   => 1,
			'taxonomy'                 => 'product_cat',
		); 
        $categories = get_categories( $args );

        echo "<div>";
			foreach ( $categories as $child ) {
				if($child->parent == 0){
					$permalink = get_term_link( $child->slug, 'product_cat' );
					if(!is_wp_error($permalink)){
						echo '<a href="'. $permalink .'" class="button success small">' . $child->name . '</a>';
					}
				}
			}
		echo "</div>";

    }    

}
/**
 * 
 */
function get_clear(){
	echo "<div ok-key='filter' opt-kind=''>";
	echo '<button ok-sel="*" class="button small expand" ng-click="showall()">Clear All filters</button>';
	echo "</div>";
}
/**
 * 
 */
function display_prod_atts_ring(){

	$getem = get_grouped_attributes();

	
	foreach ($getem as $key => $value) {
		switch ($key) {
			case 'pa_cigar-ring-gauge':
					echo "<h4>" . wc_attribute_label( $key )  . "</h4>" ;
					$fractionarray = array();
					$i = 0;

					foreach ($value as $keysub_ring => $valuesub_ring) {
						# code...
						$get_fraction = preg_replace('/[^\d-\/]+/', '', $valuesub_ring->name);
						$fractionarray[$i] = intval($valuesub_ring->name);
						$i++;
					}

					$minRing = min($fractionarray);
					$maxRing = max($fractionarray);

					echo '<div range-slider min="'. $minRing . '" max="' . $maxRing . '" model-min="userMinRing" model-max="userMaxRing"  step="1" ></div>';
					echo "<p ng-cloak class='small' ng-init=><span>Min Gauge:{{userMinRing}}</span> / <span>Max Gauge:{{userMaxRing}}</span></p><br/>";

				break;
			
			default:

				break;
		}

	}
}
function display_prod_atts_length(){

	$getem = get_grouped_attributes();

	
	foreach ($getem as $key => $value) {
		switch ($key) {
			case 'pa_cigar-length':
					$fractionarray = array();
					$i = 0;

					echo "<h4>" . wc_attribute_label( $key )  . "</h4>" ;
					foreach ($value as $keysub => $valuesub) {
						# code...
						$get_fraction 	=	preg_replace('/[^\d\s-\/]+/', '', $valuesub->name);
						$to_decimal 	=	floatval( Deci_Con($get_fraction) );
						$fractionarray[$i] = $to_decimal;
						$i++;
					}

					$minLength = min($fractionarray);
					$maxLength = max($fractionarray);
					echo '<div range-slider min="'. $minLength . '" max="' . $maxLength . '" model-min="userMinLength" model-max="userMaxLength"  step="0.125" decimal-places="3"></div>';
					echo "<p ng-cloak class='small' ng-init=><span>Min Length:{{userMinLength | fractionit:userMinLength }}</span> / <span>Max Length:{{userMaxLength | fractionit:userMaxLength}}</span></p><br/>";

				break;
			
			default:

				break;
		}

	}
}
/**
 * 
 */
function display_prod_atts(){

	$getem = get_grouped_attributes();	
	foreach ($getem as $key => $value) {
		switch ($key) {
			case 'pa_cigar-ring-gauge':

				break;

			case 'pa_cigar-length':

				break;
			default:
				echo "<h4>" . wc_attribute_label( $key )  . "</h4>" ;
		        echo "<ul class='catfilter' ok-key='filter' opt-kind=''>";

					foreach ($value as $keysub => $valuesub) {
							# code...
						echo '<li ng-click="chaindedfilters(\''.$valuesub->slug.'\')" class="filterterms" markable>' . $valuesub->name . '</li>';
					}
					
				echo "</ul>";
				break;
		}

	}
}
/**
 * 
 */
function get_grouped_attributes(){
	global $wp_query;
	$prods_atts = array();

	$id = array();
	$posts = $wp_query->posts;
	$args =  array('fields' => 'all' );
	foreach ($posts as $post) {
	  $id[] = $post->ID;
	}
	foreach ($id as $key => $value) {
		$key = 0;
		# code...
		
		$post_id = $value;
		$extended = new WC_Product($post_id);
		$attributes = $extended->get_attributes();
		
		foreach ($attributes as $attribute) {
			# code...
			$values = wc_get_product_terms( $post_id, $attribute['name'], $args );

			foreach ($values as $keysub => $valuesub) {
				# code...
				$prods_atts[$attribute['name']][$valuesub->name] = $valuesub;
			}
			$key++;
		
		}
	}
	
	return $prods_atts; 
}
/**
 * 
 */
function get_attributes($post_id, $attributes){

/*

		foreach ( $attributes as $attribute ){
			# code...
			$attrs[$key] 		= new stdClass();
			if ( $attribute['is_taxonomy'] ) {

					$values 			= wc_get_product_terms( $post_id, $attribute['name'], array( 'fields' => 'names' ) );
					
					$attrs[$key]->all 	= $attribute;
					$attrs[$key]->all['value'] = $values;					

				} else {

					// Convert pipes to commas and display values
					$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );

					$attrs[$key]->name 	= $attribute['name']; 
					$attrs[$key]->value = strip_tags(apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ) );


			}

			$key++;
		}
		return $attrs;
*/	
}
/**
 * Get's current product terms for filtering
 */
function woocommerce_get_current_tabs(){
    if (is_product_category()) {
        global $wp_query;
        $cat 			= $wp_query->get_queried_object();
        $catID 			= $cat->term_id;
		$taxonomy 		= 'product_cat';
		$cata_children 	= get_term_children( $catID, $taxonomy );
        $catslug 		= $cat->slug;
		$args 			= array( 'post_type' => 'product', $taxonomy => $catslug, 'posts_per_page' => '-1','fields' => 'ids' );
		$query 			= new WP_Query( $args );
		$argsterm 			= array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all', 'exclude' => '141');
		$posttags = wp_get_object_terms($query->posts, 'product_tag', $argsterm);
        

        echo "<div ok-key='filter' opt-kind=''>";
	    echo '<button ok-sel="*" class="button" ng-click="showall()">Show All</button>';
			foreach ($posttags as $key => $value) {
					# code...
				echo '<button ng-click="chaindedfilters(\''.$value->slug.'\')" class="button filterterms" markable>' . $value->name . '</button>';
			}
		echo "</div>";

    }

}

/**
 * Get cat slug for custom wp_query loops if needed
 */
function woocommerce_return_cat_slug(){
	    if (is_product_category()) {
        global $wp_query;
        $cat = $wp_query->get_queried_object();
        return $cat->slug;
    }

}

/**
 * This returns a number to apply to foundation for class I.E large-NUMBER
 *@param $number_of_posts = int 
 */
function return_class_number($number_of_posts){
		if($number_of_posts > 3){
			$return_value = 4;
		}elseif($number_of_posts === ""){
			$return_value = 4;
		}else{
			$return_value =  12 / $number_of_posts;
		}
		
		return $return_value;
}
/**
 * Woocommerce return image
 */
function get_image_woo($post_id){
	
	$image 				= wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );

	if( $image === false ){
		$imagereturn = '/wp-content/plugins/woocommerce/assets/images/placeholder.png';
	}else{
		$imagereturn = $image[0];
	}
	
	return $imagereturn;

}

function Deci_Con($q){
//check for a space, signifying a whole number with a fraction
    if(strstr($q, ' ')){
        $wa = strrev($q);
        $wb = strrev(strstr($wa, ' '));
        $whole = true;//this is a whole number
    }
//now check the fraction part
    if(strstr($q, '/')){
        if($whole==true){//if whole number, then remove the whole number and space from the calculations
              $q = strstr($q, ' ');
        }
$b = str_replace("/","",strstr($q, '/'));//this is the divisor
//isolate the numerator
$c = strrev($q);
$d = strstr($c, '/');
$e = strrev($d);
$a = str_replace("/","",$e);//the pre-final numerator
        if($whole==true){//add the whole number to the calculations
            $a = $a+($wb*$b);//new numerator is whole number multiplied by denominator plus original numerator    
        }
$q = $a/$b;//this is now your decimal
return $q;
    }else{
        return $q;//not a fraction, just return the decimal
    }
}