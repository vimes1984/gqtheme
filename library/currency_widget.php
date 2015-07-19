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
/* error_reporting(-1);
 ini_set('display_errors', 'On');*/
/**
 * Currency widget class.
 *
 * @package FindPartner
 * @author  Christopher Churchill <churchill.c.j@gmail.com>
 */
class CurrencyWidget extends WP_Widget{
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
    parent::__construct(
        // Base ID of your widget
        'currency_converter',
      // Widget name will appear in UI
      __('Currency Converter', 'currency_converter_widget'),
      // Widget description
      array( 'description' => __( 'Currency Converter widget', 'currency_converter_widget' ), )

    );




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

  /**
  	 * Outputs the content of the widget
  	 *
  	 * @param array $args
  	 * @param array $instance
  	 */
  	public function widget( $args, $instance ) {
  		// outputs the content of the widget
      ob_start();
        require_once('widgets/frontend/currency-widget-front.php');
      ob_end_flush();

  	}
    /**
    	 * Outputs the options form on admin
    	 *
    	 * @param array $instance The widget options
    	 */
    public function form( $instance ) {
    		// outputs the options form on admin
        ob_start();
          include('widgets/backend/currency-widget-back.php');
        ob_end_flush();
    }
    /**
     * Check if the value is selected
     * @param array $instance The widget options
     */
    public function check_selected($testcheck, $checkname){


      if($testcheck == $checkname){
        return 'selected="selected"';
      }else{
        return '';
      }

    }
    /**
    	 * check if the values are set
    	 *
       *
       * @param array $instance The widget options
    	 * @param The options string
    	 */
    public function checkvalid( $instance, $name ) {
    		// outputs the options form on admin
        if ( isset( $instance[ $name ] ) ) {
          $value = $instance[ $name ];
        }else {
         $value = __( $name, 'currency_converter' );
        }
        return $value;
    }
    /**
  	 * Processing widget options on save
  	 *
  	 * @param array $new_instance The new options
  	 * @param array $old_instance The previous options
  	 */
  	public function update( $new_instance, $old_instance ) {
  		// processes widget options to be saved
      $instance = array();
      //check options
      $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
      $instance['currency'] = ( ! empty( $new_instance['currency'] ) ) ? strip_tags( $new_instance['currency'] ) : '';
      $instance['vatrate'] = ( ! empty( $new_instance['vatrate'] ) ) ? strip_tags( $new_instance['vatrate'] ) : '';
      update_option('default_currency', $instance['currency']);
      update_option('default_vatrate', $instance['vatrate']);

      return $instance;

  	}
}
