<?php

if (!function_exists('FoundationPress_scripts')) :
  function FoundationPress_scripts() {

    // deregister the jquery version bundled with wordpress
    wp_deregister_script( 'jquery' );
    // enqueue scripts
    wp_enqueue_script('modernizr');
    wp_enqueue_script('jquery');
    wp_enqueue_script('foundation');

    // register scripts
    wp_register_script( 'modernizr', get_template_directory_uri() . '/js/vendor/modernizr.js', array(), '1.0.0', false );
    wp_register_script( 'jquery', get_template_directory_uri() . '/js/vendor/jquery.js', array(), '1.0.0', false );
    wp_register_script( 'foundation', get_template_directory_uri() . '/js/foundation.js', array('jquery'), '1.0.0', true );

    //wp_register_script( 'app', get_template_directory_uri() . '/js/custom/app.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/vendor/masonry.pkgd.min.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'angular-isotope', get_template_directory_uri() . '/js/vendor/angular-isotope.min.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'load-spinner', get_template_directory_uri() . '/js/vendor/spin.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'angular-spinner', get_template_directory_uri() . '/js/vendor/angular-spinner.min.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'angular-slider', get_template_directory_uri() . '/js/vendor/angular.rangeSlider.js', array('jquery', 'foundation'), '1.0.0', true );
    wp_enqueue_script( 'app', get_template_directory_uri() . '/js/custom/app.js', array('jquery', 'foundation'), '1.0.0', true );
  }

  add_action( 'wp_enqueue_scripts', 'FoundationPress_scripts' );
endif;