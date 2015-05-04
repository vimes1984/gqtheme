<?php

/**
 * Dance Energy Generic
 *
 * @package   dance-energy-generic
 * @author    Christopher Churchill <churchill.c.j@gmail.com>
 * @license   GPL-2.0+
 * @link      http://buildawebdoctor.com
 * @copyright 8-27-2014 BAWD
 */

/**
 * ajaxclass class.
 *
 * @package FindPartner
 * @author  Christopher Churchill <churchill.c.j@gmail.com>
 */
class ajaxclass{
	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	protected $version = "1.0.0";

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = "GQ-blends";

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	/**
	 * Slug of the plugin screen.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_screen_hook_suffix = null;

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     1.0.0
	 */
	public function __construct() {
				// Load plugin text domain
		//shop page and categories
		add_action('wp_ajax_nopriv_cats_loop', array($this, 'cats_loop') );
		add_action( 'wp_ajax_cats_loop', array($this,  'cats_loop') );
		add_action('wp_ajax_nopriv_cats_child_loop', array($this,  'cats_child_loop') );
		add_action( 'wp_ajax_cats_child_loop', array($this,  'cats_child_loop') );
		add_action('wp_ajax_nopriv_shop_page_loop', array($this, 'shop_page_loop') );
		add_action( 'wp_ajax_shop_page_loop', array($this,  'shop_page_loop') );
		add_action('wp_ajax_nopriv_single_page', array($this, 'single_page') );
		add_action( 'wp_ajax_single_page', array($this,  'single_page') );
		add_action('wp_ajax_nopriv_get_mega_menu', array($this, 'get_mega_menu') );
		add_action( 'wp_ajax_get_mega_menu', array($this,  'get_mega_menu') );
		add_action('wp_ajax_nopriv_get_mega_menu_html', array($this, 'get_mega_menu_html') );
		add_action( 'wp_ajax_get_mega_menu_html', array($this,  'get_mega_menu_html') );
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn"t been set, set it now.
		if (null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;
	}
	/****
	 	*
		*Cart Page
	 	***/




	public function get_mega_menu_html(){
		// Include the client library
		$request_body 	= file_get_contents( 'php://input' );
		$exploded 			= explode("-", $request_body );
		$postid					= end($exploded);
		$itemmeta 			= get_post_meta($postid,'_menu_item_customhtml', true);

			echo $itemmeta;
		die(); // this is required to return a proper result

	}
	public function get_mega_menu() {
		// Include the client library
		$request_body 	= file_get_contents( 'php://input' );
		$exploded 			= explode("/", $request_body );
		$catslug				= end($exploded);
		$parentcat 			= get_term_by('slug', $catslug, 'product_cat');
		$returnarray 		= array();
		$args_cats 			= array(
			'parent'			 => $parentcat->term_id,
			'child_of' 		 => $parentcat->term_id,
			'taxonomy' 		 => 'product_cat',
			'hide_empty' 	 => 0,
			'hierarchical' => true,
			'depth'  			 => 1,
			);

			$returnarray[0]['parent_name'] = $parentcat->name;
			$returnarray[0]['  b '] = $request_body;

		$categories = get_categories( $args_cats );
		$i = 1;
		foreach($categories as $cat){

			//var_dump($cat);

			$returnarray[$i]['parent_name'] = 'NULL';
			$returnarray[$i]['cat_name'] = $cat->cat_name;
			$returnarray[$i]['cat_slug'] = $cat->slug;
			$returnarray[$i]['cat_link'] = get_term_link($cat);



			$i++;
		}
		$catreturn = json_encode( $returnarray );

			echo $catreturn;
		die(); // this is required to return a proper result
	}
	/****
	 	*
		*Cart Page
	 	***/
	public function cats_loop() {
		// Include the client library
		$catreturn = array();

		$categories = get_terms( 'product_cat', 'orderby=count&hide_empty=0' );

		foreach ($categories as $key => $value) {

			if($value->parent == '0'){

				$catreturn[$key] = $value;

			}
		}

			$catreturn = json_encode( $catreturn );

			echo $catreturn;
		die(); // this is required to return a proper result
	}
	/**
	 *
	 */
	public function cats_child_loop() {
		// Include the client library
		$catreturn = array();
		$categories = get_terms( 'product_cat', 'orderby=count&hide_empty=0' );

			foreach ($categories as $key => $value) {

				if($value->parent != '0'){
					$catreturn[$key] = $value;
				}

			}
			$catreturn = json_encode( $catreturn );

			echo $catreturn;
		die(); // this is required to return a proper result
	}
	public function single_page(){
		global $product, $wpdb;

			$request_body 	= file_get_contents( 'php://input' );
			$args 					= array( 'post_type' => 'product', 'p' => $request_body, 'posts_per_page' => '1', 'post_status'=> 'publish' );
    	$decodeit     	= json_decode( $request_body );
			$query 					= new WP_Query( $args );
	  	$justmeta 			= array( );
	  	$justcats 			= array( );
	  	$justterms 			= array( );
	  	$prodsandmeta 	= array( );


		foreach ($query->posts as $key => $value) {
			global $product;

		 	$classes 			= '';
		 	$classesterm 		= '';

		 	$prodsandmeta				 = $value;
		 	$post_id 						= $value->ID;
			$extended 					= get_product($post_id);
			$getprodmet 				= get_post_meta( $post_id );
			$onsale 						= $extended->is_on_sale();
			$getprodprice 			= $this->get_product_price($post_id, $extended->product_type, $onsale);
			if($extended->product_type == 'simple'){

				$getprodavail				= $this->getproductavail($post_id, $extended->product_type, round($getprodmet['_stock'][0], 0), $getprodmet['_backorders'][0] );
				$prodsandmeta->stock_text							= $getprodavail;
				$available_variations = 'none';

			}


			if($extended->product_type === 'variable'){

				$available_variations = $extended->get_available_variations();

						//var_dump($available_variations );

				foreach($available_variations as $key => $value){


						$available_variations[$key]['value']								= $value;
						$available_variations[$key]['stock_text']	= $this->getproductavail($value['variation_id'], 'variation', round($getprodmet['_stock'][0], 0), $getprodmet['_backorders'][0] );

				}
			}else{
				$available_variations = 'none';
			}

			// IN USE PRODUCT META

		 	foreach ($getprodmet as $subkey => $subvalue){

		 		$justmeta[str_replace('-', '_', $subkey)] = $subvalue[0];

		 	}
			$prodsandmeta->available_variations		= $available_variations;
		 	$prodsandmeta->product_meta 					= $justmeta;
		 	$prodsandmeta->price 									= $getprodprice;


		}
		ob_start('ob_gzhandler');
		$backtoangular = json_encode( $prodsandmeta );


		// return $backtoangular;
		echo $backtoangular;

		die(); // this is required to return a proper result

	}
	/**
	 * Get stock extended
	 */
	public function getproductavail($post_id = '', $product_type ='', $stock = '', $backorders){
		$availtext = '';


		switch ($product_type) {
			case "simple":
				# code...
				if($backorders == 'no' && $stock == 0){

					$availtext = 'Sold Out';

				}elseif($backorders == 'yes' && $stock == 0){

					$availtext = 'Sold Out <br/> (Accepting Back Orders)';

				}elseif($backorders == 'yes' && $stock > 0) {

					$availtext = $stock . ' In Stock';

				}elseif( $backorders == 'no' && $stock > 0){

					$availtext = $stock . ' In Stock';

				}


				break;
			case "variation":
				# code...
				$deductornot 	= get_post_meta( $post_id, '_deductornot', true );
				$deductamount 	= get_post_meta( $post_id, '_deductamount', true );

				if($backorders == 'no' && $stock == 0){

					$availtext = 'Sold Out';

				}elseif($backorders == 'yes' && $stock == 0){

					$availtext = 'Sold Out <br/> (Accepting Back Orders)';

				}elseif($backorders == 'yes' && $stock > 0){


					if($deductornot == "yes"){
						$getstock = $stock / $deductamount;

						if($getstock < 1){
							$availtext =  'Sold out  <br/> (Accepting Back Orders)';

						}else{
							$availtext =  floor($getstock) . ' In Stock';

						}

					}else{

						$availtext = $stock . ' In Stock';


					}
				}elseif($backorders == 'no' && $stock > 0){


					if($deductornot == "yes"){
						$getstock = $stock / $deductamount;

						if($getstock < 1){
							$availtext =  'Sold out';

						}else{
							$availtext =  floor($getstock) . ' In Stock';

						}

					}else{

						$availtext = $stock . ' In Stock';


					}
				}

				break;

			default:
				if($backorders == 'no' && $stock == 0){

					$availtext = 'Sold Out';

				}elseif($backorders == 'yes' && $stock == 0){

					$availtext = 'Sold Out <br/> (Accepting Back Orders)';

				}elseif($backorders == 'yes' && $stock > 0) {

					$availtext = $stock . ' In Stock';

				}elseif( $backorders == 'no' && $stock > 0){

					$availtext = $stock . ' In Stock';

				}
				break;
		}

		return $availtext;
	}
	/**
	 *
	 */
	public function shop_page_loop($cat = '') {
		global $product, $wpdb;
		/*
			not in use unreliable.
			$reffer			= $_SERVER['HTTP_REFERER'];
			$catpreg  	= preg_match('#/c/(.*)/#', $reffer, $matches);
			$exploded 		= explode("/", $reffer );
			$catslug		= end($exploded);
		*/
				$request_body 	= file_get_contents( 'php://input' );

				$args 					= array( 'post_type' => 'product', 'product_cat' => $request_body, 'posts_per_page' => '-1', 'post_status'=> 'publish' );

				//not in use but may need to be...
				/*
			if($cat != ''){
				$args 					= array( 'post_type' => 'product', 'product_cat' => $cat, 'posts_per_page' => '-1', 'post_status'=> 'publish' );
			}else{
				$args 					= array( 'post_type' => 'product', 'product_cat' => $matches[1], 'posts_per_page' => '-1', 'post_status'=> 'publish' );

			}
			*/
    	$decodeit     	= json_decode( $request_body );
			$query 					= new WP_Query( $args );
	  	$justmeta 			= array( );
	  	$justcats 			= array( );
	  	$justterms 			= array( );
	  	$prodsandmeta 	= array( );
			$post_ids 			= array( );
			$thumb_ids 			= array( );

		foreach ($query->posts as $key => $value) {
			global $product;

		 	$classes 			= '';
		 	$classesterm 		= '';

		 	$prodsandmeta[$key] = new stdClass();
		 	$post_id 						= $value->ID;
			$extended 					= get_product($post_id);
			//$getprodmet 				= get_post_meta( $post_id );
			$getprodmetatts 		= get_post_meta( $post_id, '_product_attributes', true);

			if($getprodmetatts != ''){
				$arraysort 					= $this->get_attributes( $getprodmetatts );
				$get_prod_atts  		= $this->get_products_atts_withoutleak_test($post_id, $arraysort);
			}else{
				$get_prod_atts  		= NULL;

			}

			if($get_prod_atts != NULL){
				usort($get_prod_atts, array($this, 'sort_by') );
			}else{
				$get_prod_atts = array();
			}

			$getprodprice 			= $this->get_product_price($post_id, $extended->product_type);

			$imagesrc 										= wp_get_attachment_image_src(get_post_meta( $post_id, '_thumbnail_id', true) , 'medium');
			if($imagesrc != false){
				$prodsandmeta[$key]->prod_img = $imagesrc[0];
			}else{
				$prodsandmeta[$key]->prod_img = '/wp-content/plugins/woocommerce/assets/images/placeholder.png';
			}


			//IN USE Product attributes
			if($get_prod_atts != NULL){

				foreach ($get_prod_atts as $keyatts => $valueatts) {
					# code...
					foreach ($valueatts as $keysub => $valuesub) {
						# code...
							$classes 	= $classes . ' ' . $valuesub;

					}

				}
			}

			$cigar_length 						= "NULL";
			$ring_gauge 						= "NULL";

			foreach ($get_prod_atts as $key_atts => $value_atts) {
				# code...

				switch ($value_atts['parentname']) {
					case "Ring Gauge":
						# code...
						$ring_gauge =  str_replace(array("\n","\r\n"), "",  strip_tags( reset($value_atts) ) );


						break;
					case "Length":
						# code...
						$cigar_length = floatval( Deci_Con( strip_tags( reset($value_atts) ) ) );
						break;

					default:

						break;
				}
			}


			$prodsandmeta[$key]->product_attnew = $get_prod_atts;
		 	$prodsandmeta[$key]->product_title 	= $value->post_title;
		 	$prodsandmeta[$key]->ring_gauge 		= $ring_gauge;
		 	$prodsandmeta[$key]->cigar_length 	= $cigar_length;
		 	$prodsandmeta[$key]->classes 				= $classes;
			//$prodsandmeta[$key]->product_meta		= $justmeta;
		 	$prodsandmeta[$key]->wpcf_show_attributes	= get_post_meta( $post_id, 'wpcf-show-attributes', true);
		 	//$prodsandmeta[$key]->prod_term 			= $justterms;
		 	$prodsandmeta[$key]->permalink 			= get_permalink( $post_id );
		 	$prodsandmeta[$key]->price 					= $getprodprice;


		}
		ob_start('ob_gzhandler');

		$backtoangular = json_encode( $prodsandmeta );


		// return $backtoangular;
		echo $backtoangular;

		die(); // this is required to return a proper result
	}
	public function sort_by($a, $b){
    return $a['position'] - $b['position'];

	}
	/**
	 *
	 */
	public function check_for_sample_type($prods_atts){

		if(isset( $prods_atts["pa_tobacco-pack-size"]["10g"] ) ){
			return true;
		}else{
			return false;
		}

	}

	/**
	 *
	 */
	public function get_product_variations($prod_id){
		$product 		= get_product( $prod_id );
		$variations 	= $product->get_available_variations();
		$fresharray 	= array();
		foreach ($variations as $key => $value) {
			# code...
			//var_dump($value);
			if($value["price_html"]){

				$fresharray[$key] = $value["price_html"];

			}

		}
		$clear = preg_replace("/[^0-9,.]/", '', strip_tags($fresharray[1]));
		return $clear;
	}
	public function check_if_sale(){


	}
	/**
	 *
	 */
	public 	function get_product_price($prod_id, $productType, $onsale = false){
		$ID 			= $prod_id;
		$price 			= '';
		$arrayreturn 	= array();

		if($productType == 'simple'){

			$price = get_post_meta( $ID, '_regular_price', single );
			$arrayreturn 	= array('price' => $price,'type' => 'simple','onsale' => $onsale );

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
	public function get_attributes($product_attributes) {
	    return apply_filters( 'woocommerce_get_product_attributes', (array) maybe_unserialize( $product_attributes ) );
	}
	/**
	 *
	 */
		public function get_products_atts_withoutleak_test($post_ids = '', $taxonomies) {

				//var_dump($taxonomies);

				$i = 0;
				foreach ($taxonomies as $key => $value) {
					$taxnames[$i] = $value["name"];
					$i++;
				}

				$terms = wp_get_object_terms($post_ids, $taxnames, array('orderby' => 'term_order', 'order' => 'DESC', 'fields' => 'all'));



		            if ( !empty( $terms ) ) {
		                $i = 0;
		                foreach ( $terms as $term ){
												$getparenttax = get_taxonomy( $term->taxonomy );


												$out[$term->taxonomy][$term->slug] 		= $term->slug;
												//Need to redo this it causes one db call per item
												$out[$term->taxonomy]['parentname'] 	= $getparenttax->labels->name;
												$out[$term->taxonomy]['name'] 				= $term->name;
												$out[$term->taxonomy]['slug'] 				= $term->name;
												if($taxonomies[$term->taxonomy]["position"] != NULL){
		                    	$out[$term->taxonomy]['position']			= $taxonomies[$term->taxonomy]["position"];
												}else{
													$out[$term->taxonomy]['position'] 	= 0;
												}
		                    $i ++;
		                }
		            }



		    return $out;
		}
/**
 *
 */
	public function get_products_atts_withoutleak($post_id = '', $post_type = 'product') {

	    $out = array();
			$args = array('orderby' => 'count', 'order' => 'ASC', 'fields' => 'all');
			//$args['menu_order'] = isset( $args['order'] ) ? $args['order'] : 'ASC';
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
						$terms = wp_get_object_terms($post_id, $taxonomy->name, array('orderby' => 'term_order', 'order' => 'DESC', 'fields' => 'all'));
	            //$terms = wp_get_post_terms( $post_id, $taxonomy->name, $args );
	            if ( !empty( $terms ) ) {
	                $i = 0;
	                foreach ( $terms as $term ){

											$out[$taxonomy->name][$term->slug] 		= $term->slug;
											$out[$taxonomy->name]['parentname'] 	= $taxonomy->label;
											$out[$taxonomy->name]['name'] 				= $term->name;
	                    $out[$taxonomy->name]['slug'] 				= $term->name;
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
	public function get_the_terms_sorted( $post_id, $taxonomy ) {
				$terms = get_the_terms( $post_id, $taxonomy );
				function cmp_by_custom_order( $a, $b ) {
					return $a->custom_order - $b->custom_order;
				}
				if ( $terms ) usort( $terms, '_wc_get_product_terms_name_num_usort_callback' );
				return $terms;
}
/**
 *
 */
	public  function Deci_Con($q){
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
}
