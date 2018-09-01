<?php 
/**
 * Plugin Name:halloween widget 
 * Plugin URI:http://thecodestuff.com
 * Version:1.0 beta
 * Description:halloween plugin widget
 * Author:mahendra choudhary
 * Author URI:http://mahendrachoudhary.ga
 */

 # hook 
 add_action('widgets_init' , 'halloween_store_register_widgets') ;
 # registring hook
 function halloween_store_register_widgets(){
     register_widget('hs_widget') ; //'prowp_widget' is a unqiure name for widget
 }
 class hs_widget extends WP_widget{
     //process our new widget
function hs_widget() {
    $widget_ops = array(
        'classname' => 'hs-widget-class',
        'description' => __( 'Display Halloween Products',
        'halloween-plugin' )
     );

    $this->WP_Widget( 'hs_widget', __( 'Products Widget',
    'halloween-plugin'), $widget_ops );
    }    
    
    //build our widget settings form
function form( $instance ) {
    $defaults = array(
    'title' => __( 'Products', 'halloween-plugin' ),
    'number_products' => '3' );
    $instance = wp_parse_args( (array) $instance, $defaults );
    $title = $instance['title'];
    $number_products = $instance['number_products'];
    ?>
    <p><?php _e('Title', 'halloween-plugin') ?>:
    <input class="widefat"
    name="<?php echo $this->get_field_name( 'title' ); ?>"
    type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
    <p><?php _e( 'Number of Products', 'halloween-plugin' ) ?>:
    <input name="
    <?php echo $this->get_field_name( 'number_products' ); ?>"
    type="text" value="<?php echo esc_attr( $number_products ); ?>"
    size="2" maxlength="2" />
    </p>
    <?php
    }

    //save our widget settings
function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title'] = sanitize_text_field( $new_instance['title'] );
    $instance['number_products'] = absint( $new_instance['number_products'] );
    return $instance;
    }

    //display our widget
function widget( $args, $instance ) {
    global $post;
    extract( $args );
    echo $before_widget;
    $title = apply_filters( 'widget_title', $instance['title'] );
    $number_products = $instance['number_products'];
    if ( ! empty( $title ) ) { echo $before_title . esc_html( $title )
    . $after_title; };
    //custom query to retrieve products
    $args = array(
    'post_type' => 'halloween-products',
    'posts_per_page' => absint( $number_products )
    );
    $dispProducts = new WP_Query();
    $dispProducts->query( $args );
    while ( $dispProducts->have_posts() ) : $dispProducts->the_post();
    //load options array
    $hween_options_arr = get_option( 'halloween_options' );
    //load custom meta values
    $hs_price = get_post_meta( $post->ID,
    '_halloween_product_price', true );
    $hs_inventory = get_post_meta( $post->ID,
    '_halloween_product_inventory', true );
    ?>
    <p>
    <a href="<?php the_permalink(); ?>"
    rel="bookmark"
    194 ❘ CHAPTER 8 PLUGIN DEVELOPMENT
    title="<?php the_title_attribute(); ?> Product Information">
    <?php the_title(); ?>
    </a>
    </p>
    <?php
    echo '<p>' .__( 'Price', 'halloween-plugin' ). ': '
    .$hween_options_arr['currency_sign'] .$hs_price .'</p>';
    //check if Show Inventory option is enabled
    if ( $hween_options_arr['show_inventory'] ) {
    //display the inventory metadata for this product
    echo '<p>' .__( 'Stock', 'halloween-plugin' ). ': '
    .$hs_inventory .'</p>';
    }
    echo '<hr>';
    endwhile;
    wp_reset_postdata();
    echo $after_widget;
    }
}//widget class end
?>