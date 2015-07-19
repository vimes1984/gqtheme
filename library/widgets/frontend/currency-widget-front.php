<?php
/**
 * Front end currency widget
 * @param $arg = widget arguments
 * @param $instance  is a instance of this widget with it's unique settings
 * @param $getcurrencies   = get_option('avail_currencies');  is a list of the avaialble currencies
 */

 global $wp;
  $current_url        = home_url(add_query_arg(array(),$wp->request));
  $getcurrencies      = get_option('avail_currencies');
  $getvatrate         = get_option('vatrate');
  $itemcookie_value   = isset($_GET['currency_converter']) ? $_GET['currency_converter'] : $_COOKIE["currency_converter"];
  $itemcookie_vat     = isset($_GET['vat_value']) ? $_GET['vat_value'] : $_COOKIE["vat_value"];

?>

<article class="<?php echo $args['widget_id']; ?>">
    <h4><?php echo $instance['title']?></h4>
    <form action="<?php echo $current_url; ?>/" method="GET" >
        <?php
          if($itemcookie_value != NULL){
              //These come from the register options page since we are gpoing to ne
              echo '<select  class="widefat" id="currency_converter" name="currency_converter">';
              //These come from the register options page since we are gpoing to need it later

              foreach ($getcurrencies as $key => $value) {
                # code...

                echo '<option value="'  . $value['country_code'] . '" '. $this->check_selected($value['country_code'], $itemcookie_value)  .'> '. $value['name'] .'</option>';
              }
              echo '</select>';

          }else{
            echo '<select  class="widefat" id="currency_converter" name="currency_converter">';
              //These come from the register options page since we are gpoing to need it later
              foreach ($getcurrencies as $key => $value) {
                # code...

                echo '<option value="'  . $value['country_code'] . '" '. $this->check_selected($value['country_code'], $instance['currency']) .'> '. $value['name'] .'</option>';
              }
            echo '</select>';
          }
        ?>
      </select>
      <?php
      if($itemcookie_vat != NULL){
        echo '<label for="vat_value">';
        echo '<select  class="widefat" id="vat_value" name="vat_value">';
          //These come from the register options page since we are gpoing to need it later
          foreach ($getvatrate as $key => $value) {
            # code...

            echo '<option value="'  . $value['amount'] . '" '. $this->check_selected($value['amount'], $itemcookie_vat) .'> '. $value['name'] .'</option>';
          }
        echo '</select>';
        echo '</label>';

      }else{

          echo '<label for="vat_value">';
          echo '<select  class="widefat" id="vat_value" name="vat_value">';
            //These come from the register options page since we are gpoing to need it later
            foreach ($getvatrate as $key => $value) {
              # code...

              echo '<option value="'  . $value['amount'] . '" '. $this->check_selected($value['amount'], $instance['vatrate']) .'> '. $value['name'] .'</option>';
            }
          echo '</select>';
          echo '</label>';
      }

      ?>
      <button class="button expand">Save currency</button>
    </form>
</article>
