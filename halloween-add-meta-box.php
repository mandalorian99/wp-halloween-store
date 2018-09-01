<?php 
/**
 * Plugin Name:halloween meta box 
 * Plugin URI:http://thecodestuff.com
 * Description:metabox for halloween
 * Author:mahendra choudhary
 * AUthor URI:http://mahendrachoudhary.ga
 */

 /**
  * Halloween meta box code
  */

  #hook -> register metabox 
  add_action('add_meta_boxes','halloween_store_register_meta_box') ;
  #function -> register a meta box 
  function halloween_store_register_meta_box($post){
      #WP inbuilt -> create our custom meta box
      # 'halloween-products' => custom post register name > halloween-store.php line83
      add_meta_box( 'halloween-product-meta','Product Information','halloween_meta_box', 'halloween-products', 'side', 'default' ) ;
  }

  function halloween_meta_box($post){
    #retrieve our custom meta box values
    $hween_sku = get_post_meta( $post->ID, '_halloween_product_sku', true );
    $hween_price = get_post_meta( $post->ID, '_halloween_product_price', true );
    $hween_weight = get_post_meta( $post->ID, '_halloween_product_weight', true );
    $hween_color = get_post_meta( $post->ID, '_halloween_product_color', true );
    $hween_inventory = get_post_meta( $post->ID, '_halloween_product_inventory',true );

    #nonce field for security
    wp_nonce_field( 'meta-box-save', 'halloween-plugin' );
    
    # display meta box form
    echo '<table>';
        echo '<tr>';
            echo '<td>' .__('Sku', 'halloween-plugin').':</td>

                  <td><input type="text" name="halloween_product_sku" value="'.esc_attr( $hween_sku ).'" size="10"></td>';
            echo '</tr>';
            
            echo'<tr>';        
                echo '<td>' .__('Price', 'halloween-plugin').':</td>
                      <td><input type="text" name="halloween_product_price" value="'.esc_attr( $hween_price ).'" size="5"></td>';
            echo '</tr>';

                echo'<tr>';
                        echo '<td>' .__('Weight', 'halloween-plugin').':</td>
                              <td><input type="text" name="halloween_product_weight" value="'.esc_attr( $hween_weight ).'" size="5"></td>';
               echo '</tr>';
               
               echo'<tr>';
                    echo '<td>' .__('Color', 'halloween-plugin').':</td>
                          <td><input type="text" name="halloween_product_color" value="'.esc_attr( $hween_color ).'" size="5"></td>';
                echo '</tr>';
                
                echo'<tr>';
                        echo '<td>Inventory:</td>
                              <td><select name="halloween_product_inventory" id="halloween_product_inventory">
                                            <option value="In Stock"'
                                                .selected( $hween_inventory, 'In Stock', false ). '>'
                                                .__( 'In Stock', 'halloween-plugin' ). '</option>
                                        
                                            <option value="Backordered"'
                                                .selected( $hween_inventory, 'Backordered', false ). '>'
                                                .__( 'Backordered', 'halloween-plugin' ). '</option>
                                            <option value="Out of Stock"'
                                                .selected( $hween_inventory, 'Out of Stock', false ). '>'
                                                .__( 'Out of Stock', 'halloween-plugin' ). '</option>
                                            <option value="Discontinued"'
                                                .selected( $hween_inventory, 'Discontinued', false ). '>'
                                            .__( 'Discontinued', 'halloween-plugin' ). '</option>
                                    </select>
                                </td>';
                echo '</tr>';

    //display the meta box shortcode legend section
    echo '<tr><td colspan="2"><hr></td></tr>';
    echo '<tr><td colspan="2"><strong>'
    .__( 'Shortcode Legend', 'halloween-plugin' ).'</strong></td></tr>';
    echo '<tr><td>' .__( 'Sku', 'halloween-plugin' ) .':
    </td><td>[hs show=sku]</td></tr>';
    echo '<tr><td>' .__( 'Price', 'halloween-plugin' ).':
    </td><td>[hs show=price]</td></tr>';
    echo '<tr><td>' .__( 'Weight', 'halloween-plugin' ).':
    </td><td>[hs show=weight]</td></tr>';
    echo '<tr><td>' .__( 'Color', 'halloween-plugin' ).':
    </td><td>[hs show=color]</td></tr>';
    echo '<tr><td>' .__( 'Inventory', 'halloween-plugin' ).':
    </td><td>[hs show=inventory]</td></tr>';
    echo '</table>';
}

/**
 * THIS CODE IS NEED TO RE-EVOLUTED 
 */
#hook -> save form data 
add_action('save_post','halloween_store_save_meta_box') ;
#function ->save form data 
function halloween_store_save_meta_box(){
    //verify the post type is for Halloween Products and metadata has been posted
    if ( get_post_type( $post_id ) == 'halloween-products' && isset( $_POST['halloween_product_sku'] ) ) {
    
        //if autosave skip saving data
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
        return;

        //check nonce for security
        check_admin_referer( 'meta-box-save', 'halloween-plugin' );
        // save the meta box data as post metadata
        update_post_meta( $post_id, '_halloween_product_sku',
        sanitize_text_field( $_POST['halloween_product_sku'] ) );
        update_post_meta( $post_id, '_halloween_product_price',
        sanitize_text_field( $_POST['halloween_product_price'] ) );
        update_post_meta( $post_id, '_halloween_product_weight',
        sanitize_text_field( $_POST['halloween_product_weight'] ) );
        update_post_meta( $post_id, '_halloween_product_color',
        sanitize_text_field( $_POST['halloween_product_color'] ) );
        update_post_meta( $post_id, '_halloween_product_inventory',
        sanitize_text_field( $_POST['halloween_product_inventory'] ) );
    }
}
#================================UGLY CODE AHEAD NEED TO REEVALUTE=============================
/**
 * Gendrating short codes 
 */

 // Action hook to create the products shortcode
add_shortcode( 'hs', 'halloween_store_shortcode' );
//create shortcode
function halloween_store_shortcode( $atts, $content = null ) {
    global $post;
    extract( shortcode_atts( array(
        "show" => ''), $atts ) 
    );

    //load options array
    $hween_options_arr = get_option( 'halloween_options' );
    
    if ( $show == 'sku') {
        $hs_show = get_post_meta( $post->ID, '_halloween_product_sku', true );
    }elseif ( $show == 'price' ) {
        $hs_show = $hween_options_arr['currency_sign'].
        get_post_meta( $post->ID, '_halloween_product_price', true );
    }elseif ( $show == 'weight' ) {
        $hs_show = get_post_meta( $post->ID,'_halloween_product_weight', true );
    }elseif ( $show == 'color' ) {
        $hs_show = get_post_meta( $post->ID,'_halloween_product_color', true );
    }elseif ( $show == 'inventory' ) {
        $hs_show = get_post_meta( $post->ID,'_halloween_product_inventory', true );
    }

    //return the shortcode value to display
    return $hs_show;
}
  

?>