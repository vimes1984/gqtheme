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
        $permalink = get_term_link( $cat->slug, 'product_cat' );
        $i = 1;
        $secondcount = 1;
			foreach ( $categories as $child ) {
					if(!is_wp_error($permalink)){

		        		if($i === 1){
		        			echo "<div class='row'>";
		        		}
	        				echo "<div class='columns large-3 columns'> ";
								echo '<a href="'. $permalink .'/'.$child->slug.'" class="cat_links">' . $child->name . '</a>';
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
        $permalink = get_term_link( $cat->slug, 'product_cat' );
        echo "<div>";
			foreach ( $categories as $child ) {
				if($child->parent == 0){
					if(!is_wp_error($permalink)){
						echo '<a href="'. $permalink .'/'.$child->slug.'" class="button success small">' . $child->name . '</a>';
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
			case 'Ring Gauge':
      echo "<h4>" . wc_attribute_label( $key )  . "</h4>" ;
      $fractionarray = array();
      $i = 0;

      foreach ($value as $keysub_ring => $valuesub_ring) {
        # code...
        $get_fraction = preg_replace('/[^\d-\/]+/', '', $valuesub_ring['name']);
        $fractionarray[$i] = intval($valuesub_ring['name']);
        $i++;
      }

      $minRing = min($fractionarray);
      $maxRing = max($fractionarray);

      echo '<div range-slider min="'. $minRing . '" max="' . $maxRing . '" model-min="userMinRing" model-max="userMaxRing"  step="1" show-values="true"></div>';
      echo "<p class='text_under_slider'>Use the sliders to set the min & max ring gauge.</p>";

				break;

			default:

				break;
		}

	}
}

/**
*
 *
 */

function display_prod_atts_length(){

	$getem = get_grouped_attributes();


	foreach ($getem as $key => $value) {
		switch ($key) {
			case 'Length':
          $fractionarray = array();
          $i = 0;

          echo "<h4>" . wc_attribute_label( $key )  . "</h4>" ;
          foreach ($value as $keysub => $valuesub) {
            # code...
            $get_fraction 	=	preg_replace('/[^\d\s-\/]+/', '', $valuesub['name']);
            $to_decimal 	=	floatval( Deci_Con($get_fraction) );
            $fractionarray[$i] = $to_decimal;
            $i++;
          }

          $minLength = min($fractionarray);
          $maxLength = max($fractionarray);
          echo '<div range-slider min="'. $minLength . '" max="' . $maxLength . '" model-min="userMinLength" model-max="userMaxLength"  step="0.125" decimal-places="3" show-values="true" filter="fractionit"></div>';
          echo "<p class='text_under_slider'>Use the sliders to set your min &amp; max cigar length.</p>";

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
			case 'Length':
				break;

			case 'Ring Gauge':
				break;
			default:
				echo "<h4>" . $key  . "</h4>" ;
		        echo "<ul class='catfilter' ok-key='filter' opt-kind=''>";
					foreach ($value as $keysub => $valuesub) {
							# code...
						echo '<li ng-click="chaindedfilters(\''.$keysub.'\')" class="filterterms '.$keysub.'" markable>' . $valuesub['name'] . '</li>';
					}

				echo "</ul>";
				break;
		}

	}

}






// get taxonomies terms links
function custom_taxonomies_terms_links($post_id = '', $post_type = 'product') {

    $out = array();

    // get post type taxonomies
    $taxonomies = get_object_taxonomies($post_type, 'objects');
    foreach ($taxonomies as $taxonomy) {
        // get the terms related to post
        switch($taxonomy->name){
          case 'product_cat':

          break;
          case 'product_type':
          break;
          default:

            $terms = get_the_terms( $post_id, $taxonomy->name );
            if ( !empty( $terms ) ) {
                $i = 0;
                foreach ( $terms as $term ){

                    $out[$taxonomy->labels->name]['name'] = $term->name;
                    $out[$taxonomy->labels->name]['slug'] = $term->slug;
                    $i ++;
                }
            }
        break;

      }

    }
    return $out;
}
/**
 *
 */
function get_grouped_attributes(){
	global $wp_query;
	$prods_atts = array();

	$id = array();
	$resultterms = array();
  $posts = $wp_query->posts;
	$args =  array('fields' => 'all', 'orderby' => 'name', 'order' => 'ASC' );

  foreach ($posts as $post) {
	  $id[] = $post->ID;
    $attributes = custom_taxonomies_terms_links($post->ID , $post);
    $resultterms[$post->ID] =$attributes;

	}

  foreach ($resultterms as $keyname => $valuename){

    foreach ($valuename as $keysub => $valuesub) {
      # code...
      $prods_atts[$keysub][$valuesub['slug']] = $valuesub;
    }

  }

	return $prods_atts;
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
		$imagereturn = '/products-content/plugins/woocommerce/assets/images/placeholder.png';
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
/**
 * List all products on sale
 *
 * @access public
 * @param array $atts
 * @return string
 */
function woocommerce_sale_products( $atts = array() ){
    global $woocommerce_loop;

    $atts = array(
        'per_page'      => '-1',
        'columns'       => '4',
        'orderby'       => 'title',
        'order'         => 'asc'
        );

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'ignore_sticky_posts'   => 1,
        'orderby' => $atts['orderby'],
        'order' => $atts['order'],
        'posts_per_page' => $atts['per_page'],
        'meta_query' => array(
          'relation' => 'OR',
            array(
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>',
                'type' => 'NUMERIC'
            ),
            array( // Variable products type
                'key'           => '_min_variation_sale_price',
                'value'         => 0,
                'compare'       => '>',
                'type'          => 'NUMERIC'
            )
        )
    );

    ob_start();

    $products = new WP_Query( $args );



    $woocommerce_loop['columns'] = $columns;

    if ( $products->have_posts() ) :
      ?>

    <div class="row">
      <div class="large-12">
          <div id="owl-demo" class="owl-carousel owl-theme row">



            <?php while ( $products->have_posts() ) : $products->the_post();

                    global $product;
                    $extended 			= get_product($products->post->ID);
                    $getprodprice 	= get_product_price($products->post->ID, $extended->product_type, $get_prod_atts);

            ?>
                    <div class="salebox panel item" data-equalizer-watch>
                      <h6 class="text-center hommetitleslimit"><?php the_title(); ?></h6>

                      <a href="<?php the_permalink(); ?>" title="Read more about <?php the_title(); ?>" class="text-center imgcenter">
                          <?php the_post_thumbnail('medium'); ?>
                      </a>
                        <?php if($getprodprice["type"] === 'variable'){ ?>
                            <p class="text-center">From : £<?php echo $getprodprice['price']; ?></p>

                        <?php }elseif($getprodprice["type"]   === 'simple'){ ?>
                            <p class="text-center"> £<?php echo $getprodprice['price']; ?></p>

                        <?php } ?>
                      <a href="<?php the_permalink(); ?>" title="Read more about <?php the_title(); ?>" class="text-center button expand small"> Read More</a>
                    <?php //woocommerce_get_template_part( 'content', 'product' ); ?>

                    </div>
            <?php endwhile; // end of the loop. ?>
          </div>
        </div>
      </div>

    <?php endif; ?>
<?
    wp_reset_query();

    return ob_get_clean();
}
/**
 * Short Excerpt
 */
 function short_excerpt(){
    $excerpt = get_the_content();
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $the_str = substr($excerpt, 0, 140);
    return $the_str;
}
/**
 * Get price varitation for single product
 */
  function get_product_price($prod_id, $productType){
   $ID 			= $prod_id;
   $price 			= '';
   $arrayreturn 	= array();

   if($productType == 'simple'){

     $price = get_post_meta( $ID, '_regular_price', single );
     $arrayreturn 	= array('price' => $price,'type' => 'simple' );

     return $arrayreturn;



   }elseif ($productType == 'variable' && $checksample) {

     $price 	= $this->get_product_variations( $prod_id );

     $arrayreturn 	= array('price' => $price,'type' => 'tobbaco_sample' );

     return $arrayreturn;

   }elseif ($productType == 'variable') {

     $price = get_post_meta( $ID, '_min_variation_price', single );
     $arrayreturn 	= array('price' => $price,'type' => 'variable' );

     return $arrayreturn;

   }else{

     $price = get_post_meta( $ID, '_regular_price', single );
     $arrayreturn 	= array('price' => $price,'type' => 'default' );

     return $arrayreturn;

   }


 }
/**
 * Latest youtube video for glynn
 */
 function youtubevidid(){

      error_reporting(E_ALL);
      $feedURL  = 'http://gdata.youtube.com/feeds/api/users/gqtobaccos/uploads?max-results=1';
      $sxml     = simplexml_load_file($feedURL);
      $getvars  = get_object_vars($sxml->entry->link);
      $parsed   = parse_url( str_replace ( 'v=' ,  '', str_replace ( '&feature=youtube_gdata' ,  '', $getvars["@attributes"]['href'] ) ) );

      return $parsed["query"];

 }
/**
 * Degregister heartbeat...
 */
 function my_deregister_heartbeat() {
     global $pagenow;

     if ( 'post.php' != $pagenow && 'post-new.php' != $pagenow ) {
          wp_deregister_script('heartbeat');
          wp_register_script('heartbeat', false);
      }
 }
 add_action( 'admin_enqueue_scripts', 'my_deregister_heartbeat' );
