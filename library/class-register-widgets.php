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
 * Currency widget class.
 *
 * @package FindPartner
 * @author  Christopher Churchill <churchill.c.j@gmail.com>
 */
class RegisterWidgets{
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

  /**currency_widget.php
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

    add_action( 'widgets_init', array($this, 'register_CurrencyWidget') );
    //Register widget hidden options
    add_action( 'admin_init', array($this, 'register_currency_settings'));

    add_action( 'init', array($this, 'set_currency_cookie'));
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
  public function register_currency_settings(){

    $currencies = array(
                        array(
                          'country_code'=> 'USD',
                          'name'=> 'US Dollar'
                        ),
                        array(
                          'country_code'=> 'EUR',
                          'name'=> 'EURO'
                        ),
                        array(
                          'country_code'=> 'GBP',
                          'name'=> 'Great British Pound'
                        ),
                        array(
                          'country_code'=> 'AUD',
                          'name'=> 'Australian Dollar'
                        ),
                        array(
                          'country_code'=> 'JPY',
                          'name'=> 'YEN'
                        )
      );
      $vat_options = array(
                      array(
                        'name'    => 'Inc VAT (UK & EU)',
                        'amount'  => 1
                      ),
                      array(
                        'name'    => 'Exc VAT (Outside the EU)',
                        'amount'  => 1.2
                      )
      );
    update_option('vatrate', $vat_options);

    update_option('avail_currencies', $currencies);
  }
  /**
   *
   */
  public function set_currency_cookie(){

    if(isset($_GET['currency_converter'])){
      setcookie( 'currency_converter', $_GET['currency_converter'], time() + 3600, COOKIEPATH, COOKIE_DOMAIN );

    }
    if(isset($_GET['vat_value'])){
      setcookie( 'vat_value', $_GET['vat_value'], time() + 3600, COOKIEPATH, COOKIE_DOMAIN );

    }

  }
  /**
   * register Currency widget
   */
  public function register_CurrencyWidget() {
    register_widget( 'CurrencyWidget' );
  }


}
