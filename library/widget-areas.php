<?php

function foundationpress_sidebar_widgets() {
  register_sidebar(array(
      'id' => 'product-above-upsells',
      'name' => __('product above upsells', 'FoundationPress'),
      'description' => __('Drag widgets to this sidebar to appear on the product above upsells sidebar template', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));
  register_sidebar(array(
      'id' => 'product-below-upsells',
      'name' => __('product above upsells', 'FoundationPress'),
      'description' => __('Drag widgets to this sidebar to appear on the product above upsells sidebar template', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));

  register_sidebar(array(
      'id' => 'left',
      'name' => __('Left widgets', 'FoundationPress'),
      'description' => __('Drag widgets to this sidebar to appear on the left sidebar template', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));
  register_sidebar(array(
      'id' => 'post-top-left',
      'name' => __('Header top left widget keep this to one', 'FoundationPress'),
      'description' => __('Drag widgets to this header container', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));
  register_sidebar(array(
      'id' => 'post-top-middle',
      'name' => __('Header top middle widget keep this to one', 'FoundationPress'),
      'description' => __('Drag widgets to this header container', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));
    register_sidebar(array(
      'id' => 'post-top-right',
      'name' => __('Header top right widget keep this to one', 'FoundationPress'),
      'description' => __('Drag widgets to this header container', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));

  register_sidebar(array(
      'id' => 'sidebar-widgets',
      'name' => __('Sidebar widgets', 'FoundationPress'),
      'description' => __('Drag widgets to this sidebar container.', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="row widget %2$s"><div class="small-12 columns">',
      'after_widget' => '</div></article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));

  register_sidebar(array(
      'id' => 'footer-widgets',
      'name' => __('Footer widgets', 'FoundationPress'),
      'description' => __('Drag widgets to this footer container', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="large-12 columns widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));
  register_sidebar(array(
      'id' => 'post-footer-widgets',
      'name' => __('Post Footer widgets', 'FoundationPress'),
      'description' => __('Drag widgets to this footer container', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="large-12 columns widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));

  register_sidebar(array(
      'id' => 'right-cart-top',
      'name' => __('Right sidebar top', 'FoundationPress'),
      'description' => __('Drag widgets to this footer container', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));
  register_sidebar(array(
      'id' => 'right-middle',
      'name' => __('Right middle shop pages widgets', 'FoundationPress'),
      'description' => __('Drag widgets to this footer container', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));
  register_sidebar(array(
      'id' => 'right-bottom',
      'name' => __('Right Bottom widgets', 'FoundationPress'),
      'description' => __('Drag widgets to this footer container', 'FoundationPress'),
      'before_widget' => '<article id="%1$s" class="widget %2$s">',
      'after_widget' => '</article>',
      'before_title' => '<h6>',
      'after_title' => '</h6>'
  ));

}

add_action( 'widgets_init', 'foundationpress_sidebar_widgets' );
