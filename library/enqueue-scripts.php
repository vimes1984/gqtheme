<?php

if (!function_exists('FoundationPress_scripts')) :
  function FoundationPress_scripts() {
    global $wp_query;
    // deregister the jquery version bundled with wordpress
    wp_deregister_script( 'jquery' );
    //deregister wishlist style
    wp_deregister_script( 'jquery-yith-wcwl' );
    wp_deregister_script( 'jquery-selectBox' );
    wp_deregister_style( 'woocommerce_prettyPhoto_css' );
    wp_deregister_style( 'jquery-selectBox' );
    wp_deregister_style( 'yith-wcwl-main' );
    wp_deregister_style( 'yith-wcwl-user-main');
    wp_deregister_style( 'yith-wcwl-font-awesome' );
    wp_deregister_style( 'wc-bundle-css' );
    wp_deregister_style( 'wc-bundle-style' ); 

    // register scripts
    wp_register_script( 'foundation', get_template_directory_uri() . '/js/foundation.js', array(), '1.0.0', true );

    // enqueue scripts
    $yith_wcwl_l10n = array(
        'ajax_url' => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
        'redirect_to_cart' => get_option( 'yith_wcwl_redirect_cart' ),
        'multi_wishlist' => get_option( 'yith_wcwl_multi_wishlist_enable' ) == 'yes' ? true : false,
        'hide_add_button' => apply_filters( 'yith_wcwl_hide_add_button', true ),
        'is_user_logged_in' => is_user_logged_in(),
        'ajax_loader_url' => YITH_WCWL_URL . 'assets/images/ajax-loader.gif',
        'remove_from_wishlist_after_add_to_cart' => get_option( 'yith_wcwl_remove_after_add_to_cart' ),
        'labels' => array(
            'cookie_disabled' => __( 'We are sorry, but this feature is available only if cookies are enabled on your browser.', 'yit' )
        ),
        'actions' => array(
            'add_to_wishlist_action' => 'add_to_wishlist',
            'remove_from_wishlist_action' => 'remove_from_wishlist'
        )
    );

    wp_enqueue_script('foundation');
    if(is_product() || isset( $wp_query->query['wishlist-action'] ) ){

      wp_localize_script( 'foundation', 'yith_wcwl_l10n', $yith_wcwl_l10n );

    }
/*
    wp_register_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr.js', array(), '1.0.0', false );
    wp_register_script( 'jquery', get_template_directory_uri() . '/js/vendor/jquery.js', array(), '1.0.0', false );
    wp_enqueue_script( 'angular', get_template_directory_uri() . '/js/vendor/angular.min.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/vendor/masonry.pkgd.min.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'angular-isotope', get_template_directory_uri() . '/js/vendor/angular-isotope.min.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'load-spinner', get_template_directory_uri() . '/js/vendor/spin.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'angular-spinner', get_template_directory_uri() . '/js/vendor/angular-spinner.min.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'angular-slider', get_template_directory_uri() . '/js/vendor/angular.rangeSlider.js', array('jquery', 'foundation'), '1.0.0', true );
*/
  $templateslug = get_page_template_slug();
  if($templateslug == 'page-templates/homepage.php'){

    wp_enqueue_script( 'owlcarousel', get_template_directory_uri() . '/js/vendor/owl.carousel.min.js', array( 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'owlstart', get_template_directory_uri() . '/js/vendor/owlstart.js', array('foundation', 'owlcarousel'), '1.0.0', true );
  }

    wp_enqueue_script( 'app', get_template_directory_uri() . '/js/custom/app.js', array('foundation'), '1.0.0', true );

    $APPINFO = array(
      'catslug' => woocommerce_return_cat_slug(),
    );

    wp_localize_script( 'app', 'APPINFO', $APPINFO );

    //fonts
    wp_enqueue_style('font-body', "http://fonts.googleapis.com/css?family=Lato:400", array(), '1.0.0.0', true );

  }

  add_action( 'wp_enqueue_scripts', 'FoundationPress_scripts' );
endif;


/**
 * Enqueue wishlist plugin scripts.
 *
 * @return void
 * @since 1.0.0
 */
 function  enqueue_scripts() {
  global $woocommerce;

  $assets_path = str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/';

  if( function_exists( 'WC' ) ){
    $woocommerce_base = WC()->template_path();
  }
  else{
    $woocommerce_base = WC_TEMPLATE_PATH;
  }

  $located = locate_template( array(
    $woocommerce_base . 'wishlist.js',
    'wishlist.js'
  ) );

    $assets_path          = str_replace( array( 'http:', 'https:' ), '', $woocommerce->plugin_url() ) . '/assets/';
    $suffix               = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

    wp_enqueue_script( 'prettyPhoto', $assets_path . 'js/prettyPhoto/jquery.prettyPhoto' . $suffix . '.js', array( 'jquery' ), '3.1.5', true );
    wp_enqueue_script( 'prettyPhoto-init', $assets_path . 'js/prettyPhoto/jquery.prettyPhoto.init' . $suffix . '.js', array( 'jquery','prettyPhoto' ), defined( 'WC_VERSION' ) ? WC_VERSION : WOOCOMMERCE_VERSION, true );
    wp_enqueue_script( 'jquery-selectBox', YITH_WCWL_URL . 'assets/js/jquery.selectBox.min.js', array( 'jquery' ), false, true );
    wp_register_script( 'jquery-yith-wcwl', YITH_WCWL_URL . 'assets/js/jquery.yith-wcwl.js', array( 'jquery', 'jquery-selectBox' ), '2.0', true );
    wp_register_script( 'jquery-yith-wcwl-user', str_replace( get_template_directory(), get_template_directory_uri(), $located ), array( 'jquery', 'jquery-selectBox' ), '2.0', true );

    $yith_wcwl_l10n = array(
        'ajax_url' => admin_url( 'admin-ajax.php', is_ssl() ? 'https' : 'http' ),
        'redirect_to_cart' => get_option( 'yith_wcwl_redirect_cart' ),
        'multi_wishlist' => get_option( 'yith_wcwl_multi_wishlist_enable' ) == 'yes' ? true : false,
        'hide_add_button' => apply_filters( 'yith_wcwl_hide_add_button', true ),
        'is_user_logged_in' => is_user_logged_in(),
        'ajax_loader_url' => YITH_WCWL_URL . 'assets/images/ajax-loader.gif',
        'remove_from_wishlist_after_add_to_cart' => get_option( 'yith_wcwl_remove_after_add_to_cart' ),
        'labels' => array(
            'cookie_disabled' => __( 'We are sorry, but this feature is available only if cookies are enabled on your browser.', 'yit' )
        ),
        'actions' => array(
            'add_to_wishlist_action' => 'add_to_wishlist',
            'remove_from_wishlist_action' => 'remove_from_wishlist'
        )
    );

  if ( ! $located ) {
    wp_enqueue_script( 'jquery-yith-wcwl' );
    wp_localize_script( 'jquery-yith-wcwl', 'yith_wcwl_l10n', $yith_wcwl_l10n );
  }
  else {
    wp_enqueue_script( 'jquery-yith-wcwl-user' );
    wp_localize_script( 'jquery-yith-wcwl-user', 'yith_wcwl_l10n', $yith_wcwl_l10n );
  }
}
