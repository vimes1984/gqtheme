<?php
/**
 * Back end currency widget
 */

//Ceck values
$title          = $this->checkvalid( $instance, 'title' );
$currency       = $this->checkvalid( $instance, 'currency' );
$getcurrencies  = get_option('avail_currencies');
$getvatrate     = get_option('vatrate');


// Widget admin form
?>
<p>
  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>
<p>
  <label for="<?php echo $this->get_field_id( 'currency' ); ?>"><?php _e( 'Default currency:' ); ?></label>
  <select  class="widefat" id="<?php echo $this->get_field_id( 'currency' ); ?>" name="<?php echo $this->get_field_name( 'currency' ); ?>">
    <option value="">Select A Currency</option>
    <?php
      //These come from the register options page since we are gpoing to ne
      foreach ($getcurrencies as $key => $value) {
        # code...

        echo '<option value="'  . $value['country_code'] . '" '. $this->check_selected($instance['currency'], $value['country_code']) .'> '. $value['name'] .'</option>';

      }
    ?>
  </select>
  <label for="<?php echo $this->get_field_id( 'vatrate' ); ?>"><?php _e( 'Default vat rate:' ); ?></label>
  <select  class="widefat" id="<?php echo $this->get_field_id( 'vatrate' ); ?>" name="<?php echo $this->get_field_name( 'vatrate' ); ?>">
    <option value="">VAT prices</option>
        <?php
      //These come from the register options page since we are gpoing to ne
      foreach ($getvatrate as $key => $value) {
        # code...

        echo '<option value="'  . $value['amount'] . '" '. $this->check_selected($instance['vatrate'], $value['amount']) .'> '. $value['name'] .'</option>';

      }
    ?>
  </select>
</p>
