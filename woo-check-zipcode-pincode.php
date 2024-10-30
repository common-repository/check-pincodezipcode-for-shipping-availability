<?php
/**
* Plugin Name: Check Pincode/Zipcode for Shipping Availability
* Description: Check shipping is avaible or not at your location in woocommerce
*  Author: Codevyne Creatives
*  Author URI: https://www.codevyne.com/contact-us/
* Donate link: https://www.paypal.com/paypalme/pradeepku041/
* Contributors: Pradeep Maurya
* Tested up to: 5.9
* Stable tag: 3.5
* Version: 3.5
* Copyright: 2022
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
  die('-1');
}

if (!defined('WPCC_PLUGIN_VERSION')) {
  define('WPCC_PLUGIN_VERSION', '3.5');
}
if (!defined('WPCC_PLUGIN_FILE')) {
  define('WPCC_PLUGIN_FILE', __FILE__);
}
if (!defined('WPCC_PLUGIN_DIR')) {
  define('WPCC_PLUGIN_DIR',plugins_url('', __FILE__));
}
if (!defined('WPCC_BASE_NAME')) {
    define('WPCC_BASE_NAME', plugin_basename(WPCC_PLUGIN_FILE));
}
if (!defined('WPCC_DOMAIN')) {
  define('WPCC_DOMAIN', 'wpcc');
}

 include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
 
 add_action('admin_init', 'WPCC_check_woocommerce_plugin_state');
 
 function WPCC_check_woocommerce_plugin_state(){
            if ( ! ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
                set_transient( get_current_user_id() . 'wqrerror', 'message' );
            }
        }
include_once('admin/wpcc_admin_layout.php');
include_once('front/wpcc_front_layout.php');
// register plugin hook        
register_activation_hook( WPCC_PLUGIN_FILE, 'WPCC_create_table_store_pincode');


add_action( 'init', 'WPCC_load_plugin_css_js_meta' );

 function WPCC_load_plugin_css_js_meta() {
 add_action( 'admin_notices', 'WPCC_show_admin_notice');
add_action( 'admin_enqueue_scripts', 'WPCC_load_admin_script');
add_action( 'wp_enqueue_scripts',  'WPCC_load_front_script');
add_filter( 'plugin_row_meta', 'WPCC_plugin_row_metadata' , 10, 2 );
        }

function WPCC_show_admin_notice() {
if ( get_transient( get_current_user_id() . 'wqrerror' ) ) {

deactivate_plugins( plugin_basename( __FILE__ ) );
delete_transient( get_current_user_id() . 'wqrerror' );
echo '<div class="error"><p> This plugin is deactivated because it require <a href="plugin-install.php?tab=search&s=woocommerce">WooCommerce</a> plugin installed and activated.</p></div>';
            }
        }


       	
function WPCC_plugin_row_metadata( $links, $file ) {
            if ( WPCC_BASE_NAME === $file ) {
                $row_meta = array(
                    'rating'    =>  ' <a href="https://www.codevyne.com/contact-us/?utm_source=aj_plugin&utm_medium=plugin_support&utm_campaign=aj_support&utm_content=aj_wordpress" target="_blank">Support</a>',
                );
                return array_merge( $links, $row_meta );
            }
            return (array) $links;
        }


function WPCC_load_admin_script() {
            wp_enqueue_style( 'WPCC_admin_style', WPCC_PLUGIN_DIR . '/includes/css/wpcc_back_style.css', false, WPCC_PLUGIN_VERSION );
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker-alpha', WPCC_PLUGIN_DIR . '/includes/js/wp-color-picker-alpha.js', array( 'wp-color-picker' ), '1.0.0', true );
        }


function WPCC_load_front_script() {
           wp_enqueue_style( 'WPCC_front_style', WPCC_PLUGIN_DIR . '/includes/css/wpcc_front_style.css', false, WPCC_PLUGIN_VERSION );
          wp_enqueue_script( 'WPCC_front_script', WPCC_PLUGIN_DIR . '/includes/js/wpcc_front_script.js', false, WPCC_PLUGIN_VERSION );
           wp_localize_script( 'WPCC_front_script', 'wpcc_ajax_postajax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
         
            $translation_array = array('plugin_url'=>WPCC_PLUGIN_DIR);
         wp_localize_script( 'WPCC_front_script', 'wpcc_plugin_url', $translation_array );
            $not_serviceable_text = get_option('wpcc_not_serviceable_txt', 'Oops! We are not currently servicing at your location.');
            wp_localize_script( 'WPCC_front_script', 'wpcc_not_srvcbl_txt', array('not_serving'=>$not_serviceable_text) );
        }


function WPCC_create_table_store_pincode() {
            global $table_prefix, $wpdb;
       
            $tablename = $table_prefix.'wpcc_postcode';
        $query = $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->esc_like( $tablename ) );

          if ( ! $wpdb->get_var( $query ) == $tablename ) {
              
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
           
            
              $sql = "CREATE TABLE $tablename (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                wpcc_pincode TEXT NOT NULL,
                wpcc_city TEXT  NULL,
                wpcc_state TEXT NULL,
                wpcc_ddate TEXT NOT NULL,
                wpcc_ship_amount TEXT NOT NULL,
                wpcc_cod TEXT NOT NULL,
                wpcc_cod_amount TEXT NOT NULL,
                PRIMARY KEY (id)
            )  ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";

           $results = $wpdb->query($sql);
          
} 
        }
   
