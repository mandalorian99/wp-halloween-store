<?php 
/**
 * Plugin Name:Halloween 
 * Plugin URI :http://thecodestuff.com
 * Description:Halloween is a demo plugin develop by mahendra choudhary
 * Version:1.0 
 * Author:Mahendra Choudhary
 * Author URI:http://thecodestuff.com
 * Licence: GPLv2
 */
/* Copyright 2018 mahendra choudhary (email : info.thecodestuff@gmail.com)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/

/**
 * registrering plugin on activation code
 */
#hook
register_activation_hook( __FILE_ ,'halloween_store_install' ) ;
#function 
function halloween_store_install(){
    #default options
    $hween_options_arr=array(
        'currency_sign'=>'$'
    ) ;
    #update options
    update_options('halloween_options',$hween_options_arr) ;
    
}

/**
 * Registering custom post type code
 */

 #hook 
 add_action('init','halloween_store_init') ;
 #function intilize the halloween product store
 function halloween_store_init(){
     #registering custom post type
     #labels are the provided arguments by the wp
     $labels=array(
        'name' => __( 'Products', 'halloween-plugin' ),
        'singular_name' => __( 'Product', 'halloween-plugin' ),
        'add_new' => __( 'Add New', 'halloween-plugin' ),
        'add_new_item' => __( 'Add New Product', 'halloween-plugin' ),
        'edit_item' => __( 'Edit Product', 'halloween-plugin' ),
        'new_item' => __( 'New Product', 'halloween-plugin' ),
        'all_items' => __( 'All Products', 'halloween-plugin' ),
        'view_item' => __( 'View Product', 'halloween-plugin' ),
        'search_items' => __( 'Search Products', 'halloween-plugin' ),
        'not_found' => __( 'No products found', 'halloween-plugin' ),
        'not_found_in_trash' => __( 'No products found in Trash','halloween-plugin' ),
        'menu_name' => __( 'Products', 'halloween-plugin' )
     );
     #arguments > labels array goes here > and arugment goes in register_post_type
     $args=array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' )
     );

     
     #wp function to our custom post types , all options and supporta are given in $args
     register_post_type('halloween-products',$args) ;
 }
 
?>