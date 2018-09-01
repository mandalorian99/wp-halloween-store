<?php
/**
 * Plugin Name:halloween settings
 * Plugin URI:http://thecodestuff.com
 * Description:create a submenu and settings page
 * Author:mahendra choudhary
 * Author URI:http://mahendrachoudhary.ga
 */

/**
 * add a option in setting menu | setting>halloween setting
 * Customize setting page |intercat with settings API
 */

 #hook 
 add_action('admin_menu','halloween_store_menu') ;

 #function> this add a option in setting menu 
 function halloween_store_menu(){
     #using WP in built function
     add_options_page('HALLOWEEN CUSTOM SETTINGS','halloween settings','manage_options','halloween-store-settings','halloween_store_settings_page') ;
 }
#build setting page
 function halloween_store_settings_page(){
     #fetch previously defined options from halloween store file
     $hween_options_arr = get_option('halloween_options') ;
     #set the options array values to variable
     $hs_inventory=( !empty($hween_options_arr['show_inventory']) )?$hween_options_arr['show_inventory']: '';
     $hs_currency_sign =$hween_options_arr['currency_sign'] ;

?>
    <div class="wrap">
        <h1><?php _e('Halloween Store Options','halloween-plugin') ;?></h1>

        <form method="post" action="options.php">
            <!---calling a nonce-->
            <?php settings_fields('halloween-setting-group')?>
            <table>
                <tr>
                    <th><?php _e('Show inventory' , 'halloween-plugin') ;?></th>
                    <td><input type="checkbox" name="halloween_options[show_inventory]" value="<?php echo esc_attr( $hs_inventory) ; ?>" ></td>
                </tr>
                <tr>
                    <th><?php _e('Currency sign','halloween-plugin') ; ?></th>
                    <td><input type="text" name="halloween_options[currency_sign]" value="<?php echo esc_attr( $hs_currency_sign ) ;?>" size="1" maxlength="1"></td>
                </tr>
            </table>
            <p><input type="submit" class="button-primary" value="<?php _e('Save Changes','halloween-plugin'); ?>"></p>
        </form>
    </div>
<?php
 }

 /**
  * Get form data and sanitize it -> store in database
  */

  #hook -> register the plugin option setting
  add_action('admin_init' , 'halloween_store_register_settings') ;
  #function -> it registe the option setting
  function halloween_store_register_settings(){
      #wp in built to register function , hallween_options use to access name of form 
      register_setting('halloween-setting-group','halloween_options','halloween_sanitize_options') ;
  }

  function halloween_sanitize_options( $options ){
    $options['show_inventory'] = ( ! empty( $options['show_inventory'] ) ) ?sanitize_text_field( $options['show_inventory'] ) : '';

    $options['currency_sign'] = ( ! empty( $options['currency_sign'] ) ) ?sanitize_text_field( $options['currency_sign'] ) : '';
    
    return $options;
  }
?>