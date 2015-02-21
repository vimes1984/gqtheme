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
	private function __construct() {
				// Load plugin text domain
		//shop page and categories
		add_action('wp_ajax_nopriv_cats_loop', array($this, 'cats_loop') );
		add_action( 'wp_ajax_cats_loop', array($this,  'cats_loop') );
		add_action('wp_ajax_nopriv_cats_child_loop', array($this,  'cats_child_loop') );
		add_action( 'wp_ajax_cats_child_loop', array($this,  'cats_child_loop') );
		add_action('wp_ajax_nopriv_shop_page_loop', array($this, 'shop_page_loop') );
		add_action( 'wp_ajax_shop_page_loop', array($this,  'shop_page_loop') );
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
	/**
	 * 
	 */
	public function shop_page_loop() {
		global $product;
		

		$reffer			= $_SERVER['HTTP_REFERER'];
		$exploded 		= explode("/", $reffer );
		$catslug		= end($exploded);
		//var_dump($exploded);
		//not in use but may need to be...
		$request_body 	= file_get_contents( 'php://input' );

		$args 			= array( 'post_type' => 'product', 'product_cat' => $request_body, 'posts_per_page' => '-1', 'post_status'=> 'publish' );
        $decodeit     	= json_decode( $request_body );
		$query 			= new WP_Query( $args );
	  	$justmeta 		= array( );
	  	$justcats 		= array( );
	  	$justterms 		= array( );
	  	$prodsandmeta 	= array( );

		foreach ($query->posts as $key => $value) {
			global $product;

		 	$classes 			= '';
		 	$classesterm 		= '';
		 	$prodsandmeta[$key] = $value;		 	
		 	$post_id 			= $value->ID;
			$extended 			= new WC_Product($post_id);
			$getprodprice 		= $this->get_product_price($post_id);
			$image 				= wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'single-post-thumbnail' );	 	
			$getprodmet 		= get_post_meta( $post_id );
			$get_prod_atts  	= $this->get_products_atts($post_id);

			//Not In use 
		 	//$categories 		= get_the_terms( $post_id, 'product_cat' );
			//$posttags 			= wp_get_object_terms($post_id, 'product_tag');			

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
			/*
				//NOT IN USE TO GET AND FILTER BY TAGS
				foreach ($posttags as $subtermkey => $subtermvalue) {
					$classes 	= $classes . ' ' . $subtermvalue->slug;
					$justterms 	=  $subtermvalue;
				}
			 	
			 	//NOT IN USE TO GET AND FILTER THE CATS 
			 	if($categories){

			 		foreach ($categories as $subcatkey => $subcatvalue) {
			 		
			 			$classes = $classes . ' ' . $subcatvalue->slug;
			 			$justcats[$subcatkey] = $subcatvalue;

			 		}
			 	}
			*/

			// IN USE PRODUCT META
		 	foreach ($getprodmet as $subkey => $subvalue){

		 		$justmeta[str_replace('-', '_', $subkey)] = $subvalue[0];
		 	
		 	}
			$prods_atts 						= $this->get_attributes($post_id, $extended->get_attributes());
			$cigar_length 						= "NULL";
			$ring_gauge 						= "NULL";
			foreach ($prods_atts as $key_atts => $value_atts) {
				# code...
				switch ($value_atts->name) {
					case "Ring Gauge":
						# code...
						$ring_gauge = str_replace(array("\n","\r\n"), "",  strip_tags( $value_atts->value ) );
						
						
						break;
					case "Length":
						# code...
						$cigar_length = floatval( Deci_Con( strip_tags( $value_atts->value ) ) );
						break;
										
					default:
						
						break;
				}
			}
		 	//$prodsandmeta[$key]->prod_cat 		= $justcats;
		 	//$prodsandmeta[$key]->classesterm 	= $classesterm;
		 	$prodsandmeta[$key]->product_att 	= $prods_atts;
		 	$prodsandmeta[$key]->ring_gauge 	= $ring_gauge;
		 	$prodsandmeta[$key]->cigar_length 	= $cigar_length;
		 	$prodsandmeta[$key]->classes 		= $classes;
		 	$prodsandmeta[$key]->product_meta 	= $justmeta;
		 	$prodsandmeta[$key]->prod_term 		= $justterms;
		 	$prodsandmeta[$key]->permalink 		= get_permalink( $post_id );
		 	$prodsandmeta[$key]->price 			= $getprodprice;

		 	if( $image === false ){
		 		$prodsandmeta[$key]->prod_img = '/wp-content/plugins/woocommerce/assets/images/placeholder.png';
		 	}else{
		 		$prodsandmeta[$key]->prod_img = $image[0];
		 	}

		 	//var_dump($key);
		}

		$backtoangular = json_encode( $prodsandmeta );
		
		echo $backtoangular;
		
		die(); // this is required to return a proper result
	}
	/**
	 * 
	 */
	public function check_for_sample_type($prod_id){
		$prods_atts 	= $this->get_products_atts($prod_id);
		$getsample 		= $prods_atts["pa_tobacco-pack-size"]["10g"];

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

	/**
	 * 
	 */
	public 	function get_product_price($prod_id){
		$product 		= get_product( $prod_id );
		$ID 			= $prod_id;
		$productType 	= $product->is_type('simple');
		$price 			= '';
		$checksample 	= $this->check_for_sample_type($prod_id);
		$arrayreturn 	= array();
		//var_dump($product);

		if($product->is_type('simple')){

			$price = get_post_meta( $ID, '_regular_price', single );
			$arrayreturn 	= array('price' => $price,'type' => 'simple' );

			return $arrayreturn;



		}elseif ($product->is_type('variable') && $checksample) {

			$price 	= $this->get_product_variations( $prod_id );

			$arrayreturn 	= array('price' => $price,'type' => 'tobbaco_sample' );

			return $arrayreturn;

		}elseif ($product->is_type('variable')) {

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
	 * 
	 */
	public function get_products_atts($post_id = 0){
		$extended = new WC_Product($post_id);
		$attributes = $extended->get_attributes();
		$args =  array('fields' => 'all' );

		foreach ($attributes as $attribute) {
		# code...
		$values = wc_get_product_terms( $post_id, $attribute['name'], $args );

			foreach ($values as $keysub => $valuesub) {
			# code...
				$prods_atts[$attribute['name']][$valuesub->slug] = $valuesub->slug;
			}
		}

		return $prods_atts;
	}
	/**
	 * 
	 */
	public function get_attributes($post_id, $attributes){
		$key = 0;
		$attrs =  array();

		foreach ( $attributes as $attribute ){
			# code...
			$attrs[$key] 		= new stdClass();
			if ( $attribute['is_taxonomy'] ) {

					$values 			= wc_get_product_terms( $post_id, $attribute['name'], array( 'fields' => 'names' ) );
					
					$attrs[$key]->value = ( apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ) );
					$attrs[$key]->name 	= wc_attribute_label( $attribute['name'] ); 

				} else {

					// Convert pipes to commas and display values
					$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );

					$attrs[$key]->name 	= wc_attribute_label( $attribute['name'] ); 
					$attrs[$key]->value = apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );


			}

			$key++;
		}
		return $attrs;
	
	}
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