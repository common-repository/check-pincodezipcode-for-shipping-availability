<?php

if (!defined('ABSPATH'))
    exit;

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

if (!class_exists('WPCC_menu')) {
    class WPCC_menu {
        protected static $instance;
        function WPCC_admin_menu() {
           
            add_menu_page( 
                
                __( 'Post/Zip codes', 'wpcc' ), 
                __( 'Post/Zip codes', 'wpcc' ),
                'manage_options', 
                'post-code',
                array($this,'WPCC_list_postcode'),
                'dashicons-location',
                10
            );
            add_submenu_page( 
                'post-code', 
                __( 'Add Post/Zip codes', 'wpcc' ), 
                __( 'Add Post/Zip codes', 'wpcc' ),
                'manage_options', 
                'add-post-code',
                array($this,'WPCC_add_postcode')
            );

            add_submenu_page( 
                'post-code', 
                __( 'Settings', 'wpcc' ),  
                __( 'Settings', 'wpcc' ),
                'manage_options', 
                'post-code-setting',
                array($this,'WPCC_setting')
            );
            add_submenu_page( 
                'post-code', 
                __( 'Import Post/Zip codes', 'wpcc' ), 
                __( 'Import Post/Zip codes', 'wpcc' ),
                'manage_options', 
                'post-code-import',
                array($this,'WPCC_import_postcode')
            );
        }


        function WPCC_add_postcode() {
            global $wpdb;
            $tablename=$wpdb->prefix.'wpcc_postcode';

            if(isset($_REQUEST['action']) && $_REQUEST['action'] == "oc_edit") {
                $pincode = sanitize_text_field($_REQUEST['id']);
                $cntSQL = "SELECT * FROM {$tablename} where id='".$pincode."'";
                $record = $wpdb->get_results($cntSQL, OBJECT);
                ?>
                    <div class="wrapper">
                        <div class="wpcc_container">
                            <h2>Update Post/Zip Code</h2>

                            <?php
                            if(isset($_GET['update']) && $_GET['update'] == 'exists') {
                                echo "<div class='wpcc_notice_error'><p>Sorry, pincode already exists in records.</p></div>";
                            }

                            if(isset($_GET['update']) && $_GET['update'] == 'success') {
                                echo "<div class='wpcc_notice_success'><p>Pincode updated successfully.</p></div>";
                            }

                            ?>

                            <form method="post">
                                <?php wp_nonce_field( 'WPCC_update_postcode_action', 'WPCC_update_postcode_field' ); ?>
                                <table class="wpcc_table">
                                    <tr>
                                        <td>Pincode</td>
                                        <td>
                                            <input type="text" name="txtpincode" value="<?php echo $record[0]->wpcc_pincode; ?>" required="">
                                            <input type="hidden" name="txtid" value="<?php echo $record[0]->id; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td><input type="text" name="txtcity" value="<?php echo $record[0]->wpcc_city; ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>State</td>
                                        <td><input type="text" name="txtstate" value="<?php echo $record[0]->wpcc_state; ?>" required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery within days</td>
                                        <td>
                                            <input type="number" name="txtdelivery" min=0 value="<?php echo $record[0]->wpcc_ddate; ?>" required="">
                                            <td><strong>Note : If you add zero so Delivery Day count is same day</strong><td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Amount</td>
                                        <td>
                                            <input type="number" name="txtshippingamount" min=0 value="<?php echo $record[0]->wpcc_ship_amount; ?>" >
                                            <td><strong>Note : If Enable shipping cost in setting so that count shipping amount</strong><td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cash on Delivery</td>
                                        <td>
                                            <input type="checkbox" id="codstatus" name="txtcod" value="1" <?php if($record[0]->wpcc_cod == '1') { echo 'checked'; } ?>>
                                        </td>
                                    </tr>
                                     <tr id="codavailable">
                                        <td>Cash on Delivery Amount</td>
                                        <td>
                                            <input type="number" name="txtcodamount" min=0 value="<?php echo $record[0]->wpcc_cod_amount; ?>" >
                                            <td><strong>Note : If COD option is enable then COD amount will count on cart and checkout page</strong><td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="hidden" name="action" value="wpcc_update_postcode">
                                            <input type="submit" name="wpcc_update_postcode" value="Update">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                <?php
            } else {
                ?>
                    <div class="wrap">
                        <div class="wpcc_container">
                            <h2>Add Post/Zip Code</h2>
                            
                            <?php
                            if(isset($_GET['add']) && $_GET['add'] == 'exists') {
                                echo "<div class='wpcc_notice_error'><p>Sorry, pincode already exists in records.</p></div>";
                            }

                            if(isset($_GET['add']) && $_GET['add'] == 'success') {
                                echo "<div class='wpcc_notice_success'><p>Pincode added successfully.</p></div>";
                            }

                            ?>

                            <form method="post">
                                <?php wp_nonce_field( 'WPCC_add_postcode_action', 'WPCC_add_postcode_field' ); ?>

                                <table class="wpcc_table">
                                    <tr>
                                        <td>Pincode</td>
                                        <td><input type="text" name="txtpincode" <?php if(isset($_GET['txtpincode']) && $_GET['txtpincode'] != '') { echo 'value='.esc_attr( $_GET['txtpincode'] ); } ?> required=""></td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td><input type="text" name="txtcity" <?php if(isset($_GET['txtcity']) && $_GET['txtcity'] != '') { echo 'value='.esc_attr( $_GET['txtcity'] ); } ?> required=""></td>
                                    </tr>
                                    <tr>
                                        <td>State</td>
                                        <td><input type="text" name="txtstate" <?php if(isset($_GET['txtstate']) && $_GET['txtstate'] != '') { echo 'value='.esc_attr( $_GET['txtstate'] ); } ?> required=""></td>
                                    </tr>
                                    <tr>
                                        <td>Shipping Amount</td>
                                        <td>
                                           <input type="text" name="txtshippingamount" <?php if(isset($_GET['txtshippingamount']) && $_GET['txtshippingamount'] != '') { echo 'value='.esc_attr( $_GET['txtshippingamount'] ); } ?> >     
                                           <td><strong>Note : If Enable shipping cost in setting so that count shipping amount</strong><td>                              
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Delivery within days</td>
                                        <td><input type="number" name="txtdelivery" min='0' <?php if(isset($_GET['txtdelivery']) && $_GET['txtdelivery'] != '') { echo 'value='.esc_attr( $_GET['txtdelivery'] ); } ?> required=""></td>
                                        <td><strong>Note : If you add zero so Delivery Day count is same day</strong><td>
                                    </tr>
                                    <tr>
                                        <td>Cash on Delivery</td>
                                        <td>
                                            <input type="checkbox" name="txtcod" id="codstatus" value="1" <?php if(isset($_GET['txtcod']) && $_GET['txtcod'] == '1' ) { echo 'checked'; } ?>>
                                        </td>
                                    </tr>
                                       <tr id="codavailable">
                                        <td>Cash on Delivery Amount</td>
                                        <td>
                                            <input type="number" name="txtcodamount" min=0 <?php if(isset($_GET['txtcodamount']) && $_GET['txtcodamount'] != '') { echo 'value='.esc_attr( $_GET['txtcodamount'] ); } ?>>
                                            <td><strong>Note : If COD option is enable then COD amount will count on cart and checkout page</strong><td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                          <input type="hidden" name="action" value="wpcc_add_postcode">
                                          <input type="submit" name="wpcc_add_postcode" value="Add">
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                <?php
            }
        }


        function WPCC_import_postcode() {
            ?>
            <div class="wrapper">
                <div class="wpcc_container">
                    <h2>Bulk Import Post/Zip Codes</h2>

                    <?php
                    if(isset($_GET['import']) && $_GET['import'] == 'error') {
                        echo "<div class='wpcc_notice_error'><p>Import failed, invalid file extension or something bad happened.</p></div>";
                    }

                    if(isset($_GET['import']) && $_GET['import'] == 'success') {
                        $records = '';
                        if(isset($_GET['records']) && $_GET['records'] != '') {
                            $records = sanitize_text_field($_GET['records']);
                        }
                        echo "<div class='wpcc_notice_success'><p>Total Records inserted: ".$records."</p></div>";
                    }

                    ?>

                    <form method='post' enctype='multipart/form-data' class="wpcc_import">
                        <?php wp_nonce_field( 'WPCC_import_postcodes_action', 'WPCC_import_postcodes_field' ); ?>
                        <div class="wpcc_importbox">
                            <h3>Bulk import post/Zip codes via csv</h3>
                            <input type="file" name="import_file" required="" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            <input type="hidden" name="action" value="wpcc_import_postcodes">
                            <input type="submit" name="butimport" value="Import">
                        </div>
                        <a href="<?php echo WPCC_PLUGIN_DIR.'/wpcc_pincode_sample.csv'; ?>" download='sample_pincode.csv' class="wpcc_demo_file">Download sample file</a>
                        <p class="description">This is the sample file of pincodes for csv import.</p>
                        <p><strong><span style="color:red;font-weight:bold;">Note: </span></strong> In CSV File, you have to add only <span style="color:red;font-weight:bold;">0 </span>or <span style="color:red;font-weight:bold;">1</span> value under <b>Cash on Delivey</b> column. <span style="color:red;font-weight:bold;">0</span> = <b>COD not enable</b>, <span style="color:red;font-weight:bold;">1</span> = <b>COD enable</b></p>
                    </form>
                </div>
            </div>
            <?php
        }


        function WPCC_list_postcode() {
            $exampleListTable = new WPCC_List_Table();
            $exampleListTable->prepare_items();
            ?>
            <div class="wrap">
                <div class="wpcc_container">
                    <h2>List Post/Zip Code</h2>

                    <?php
                    if(isset($_GET['delete']) && $_GET['delete'] == 'success') {
                        echo "<div class='wpcc_notice_success'><p>Record deleted successfully.</p></div>";
                    }                    
                    ?>

                    <form  method="post" class="wpcc_list_postcode">
                        <a href="?page=add-post-code"  class="button wpcc_add_postcode" style="background-color:#2271b1;border-color:#2271b1;color:#fff;">Add Post/Zip codes</a>
                        <a href="?page=post-code-import"  class="button wpcc_import_bulk" style="background-color:#3f51b5;border-color:#3f51b5;color:#fff;">Import Bulk Post/Zip codes</a>
                        <input type="submit" name="all_record_delete" class="button wpcc_all_delete" onclick="return confirm('Are you sure you want to delete this item?');" value="Delete All Pincode" style="background-color:red;color:#fff;border-color:red;">
                        <?php
                            $page  = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_STRIPPED );
                            $paged = filter_input( INPUT_GET, 'paged', FILTER_SANITIZE_NUMBER_INT );

                            printf( '<input type="hidden" name="page" value="%s" />', $page );
                            printf( '<input type="hidden" name="paged" value="%d" />', $paged ); 
                        ?>
                        <?php $exampleListTable->display(); ?>
                    </form>
                </div>
            </div>
            <?php
        }


        function WPCC_setting() {
            ?>
            <div class="wrapper">
                <div class="wpcc_container">
                    <form method="post" class="oc_wpcc">
                        <?php wp_nonce_field( 'wpcc_nonce_action', 'wpcc_nonce_field' ); ?>
                        <table class="wpcc_table">
                            <h2>Basic Settings</h2>
                            <tr>
                                <td>Enable Pincode Availability Check</td>
                                <td>
                                    <input type="checkbox" name="wpcc_enable_checkpcode" <?php if( get_option('wpcc_enable_checkpcode', 'on') == 'on' ) { echo 'checked'; } ?>>
                                </td>
                            </tr>
                        
                                 <tr>
                                <td>Enable Shipping Cost</td>
                                <td>
                                    <input type="checkbox" name="wpcc_enable_shipping_cost" <?php if( get_option('wpcc_enable_shipping_cost', 'on') == 'on' ) { echo 'checked'; } ?>>
                                </td>
                            </tr>
                            
                                 <tr>
                                <td>Show Delivery Date</td>
                                <td>
                                    <input type="checkbox" name="wpcc_del_shw" <?php if( get_option('wpcc_del_shw', 'on') == 'on' ) { echo 'checked'; } ?>>

                                </td>
                            </tr>
                             
                            <tr>
                                <td>Show Cash On Delivery Option</td>
                                <td>
                                    <input type="checkbox" name="wpcc_cash_dilivery_shw" <?php if( get_option('wpcc_cash_dilivery_shw', 'on') == 'on' ) { echo 'checked'; } ?>>
                                </td>
                            </tr>
                            <tr>
                                <td>Pincode Availability Check Position</td>
                                <td>
                                    <select name="wpcc_checkpcode_pos">
                                        <option value="after_atc" <?php if(get_option('wpcc_checkpcode_pos', 'after_atc') == 'after_atc') { echo 'selected'; } ?>>After Add to Cart Button</option>
                                        <option value="before_atc" <?php if(get_option('wpcc_checkpcode_pos', 'after_atc') == 'before_atc') { echo 'selected'; } ?>>Before Add to Cart Button</option>
                                        <option value="use_shortcode" <?php if(get_option('wpcc_checkpcode_pos', 'after_atc') == 'use_shortcode') { echo 'selected'; } ?>>Use Shortcode</option>
                                    </select>
                                    <p class="wpcc_scode_info">You can use shortcode <strong>[wpcc_check_pincode]</strong> to place it anywhere you like to use in website and select "Use Shortcode" in above select option.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>Check Button Text</td>
                                <td>
                                    <input type="text" name="wpcc_btn_txt" value="<?php echo get_option('wpcc_btn_txt', 'Check'); ?>" >
                                </td>
                            </tr>
                          

                            <tr class="wpcc_nosrvtxt">
                                <td>Delivery Date Text</td>
                                <td>
                                    <input type="text" name="wpcc_delivery_date_txt" value="<?php echo get_option('wpcc_delivery_date_txt', 'Estimated delivery in'); ?>">
                                </td>
                            </tr>
                            <tr class="wpcc_nosrvtxt">
                                <td>Cash On Delivery label text</td>
                                <td>
                                    <input type="text" name="wpcc_cash_on_delivery_txt" value="<?php echo get_option('wpcc_cash_on_delivery_txt', 'Cash On Delivery'); ?>">
                                </td>
                            </tr>
                            <tr class="wpcc_nosrvtxt">
                                <td>Check Availability At label Text</td>
                                <td>
                                    <input type="text" name="wpcc_availability_label_txt" value="<?php echo get_option('wpcc_availability_label_txt', 'Check Availability At'); ?>" >
                                  
                                </td>
                            </tr>
                        </table>
						<table class="wpcc_table">
                            <h2>Shop & Product Settings</h2>
                            <tr>
                                <td>Hide Addtocart button on Shop Page</td>
                                <td>
                                    <input type="checkbox" name="wpcc_hide_addtocart_sbtn" <?php if( get_option('wpcc_hide_addtocart_sbtn', 'off') == 'on' ) { echo 'checked'; } ?>>
                                </td>
                            </tr>
                        
                                 <tr>
                                <td>Disable Addtocart Button on Single Product Page</td>
                                <td>
                                    <input type="checkbox" name="wpcc_disable_addtocart_pbtn" <?php if( get_option('wpcc_disable_addtocart_pbtn', 'off') == 'on' ) { echo 'checked'; } ?>>
                                </td>
                            </tr>
                            
                        </table>
                        <table class="wpcc_table">
                            <h2>Design Settings</h2>
                            <tr class="wpcc_color_tr">
                                <td>Box Background Color</td>
                                <td>
                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo get_option( 'wpcc_box_bg_clr', '#f2f2f2' ); ?>" name="wpcc_box_bg_clr" value="<?php echo get_option( 'wpcc_box_bg_clr', '#f2f2f2' ); ?>"/>
                                </td>
                            </tr>
                            <tr class="wpcc_color_tr">
                                <td>Check Input Box Background Color</td>
                                <td>
                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo get_option( 'wpcc_check_ibox_bg_clr', '#ffffff' ); ?>" name="wpcc_check_ibox_bg_clr" value="<?php echo get_option( 'wpcc_check_ibox_bg_clr', '#ffffff' ); ?>"/>
                                </td>
                            </tr>
                            <tr class="wpcc_color_tr">
                                <td>Button Background Color</td>
                                <td>
                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo get_option( 'wpcc_bg_clr', '#8bc34a' ); ?>" name="wpcc_btn_bg_clr" value="<?php echo get_option( 'wpcc_bg_clr', '#8bc34a' ); ?>"/>
                                </td>
                            </tr>
                            <tr class="wpcc_color_tr">
                                <td>Button Text Color</td>
                                <td>
                                    <input type="text" class="color-picker" data-alpha="true" data-default-color="<?php echo get_option( 'wpcc_txt_clr', '#ffffff' ); ?>" name="wpcc_btn_txt_clr" value="<?php echo get_option( 'wpcc_txt_clr', '#ffffff' ); ?>"/>
                                </td>
                            </tr>
                            
                          
                        </table>
                       
                        <input type="hidden" name="action" value="WPCC_settings_save">
                        <input type="submit" name="wpcc_txtadd_design" value="Save">
                    </form>
                </div>
            </div>
            <?php
        }

        function WPCC_save_options() {
            if( current_user_can('administrator') ) { 
                global $wpdb;
                $tablename=$wpdb->prefix.'wpcc_postcode';

                if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'WPCC_settings_save') {
                    if(!isset( $_POST['wpcc_nonce_field'] ) || !wp_verify_nonce( $_POST['wpcc_nonce_field'], 'wpcc_nonce_action' )) {
                        
                        echo 'Sorry, your nonce did not verify.';
                        exit;

                    } else {

                        if(isset($_REQUEST['wpcc_enable_checkpcode']) && !empty($_REQUEST['wpcc_enable_checkpcode'])) {
                            $wpcc_enable_checkpcode = sanitize_text_field( $_REQUEST['wpcc_enable_checkpcode'] );
                        } else {
                            $wpcc_enable_checkpcode = 'off';
                        }
                        if(isset($_REQUEST['wpcc_enable_shipping_cost']) && !empty($_REQUEST['wpcc_enable_shipping_cost'])) {
                            $wpcc_enable_shipping_cost = sanitize_text_field( $_REQUEST['wpcc_enable_shipping_cost'] );
                        } else {
                            $wpcc_enable_shipping_cost = 'off';
                        }
						
						if(isset($_REQUEST['wpcc_hide_addtocart_sbtn']) && !empty($_REQUEST['wpcc_hide_addtocart_sbtn'])) {
                            $wpcc_hide_addtocart_sbtn = sanitize_text_field( $_REQUEST['wpcc_hide_addtocart_sbtn'] );
                        } else {
                            $wpcc_hide_addtocart_sbtn = 'off';
                        }

						if(isset($_REQUEST['wpcc_disable_addtocart_pbtn']) && !empty($_REQUEST['wpcc_disable_addtocart_pbtn'])) {
                            $wpcc_disable_addtocart_pbtn = sanitize_text_field( $_REQUEST['wpcc_disable_addtocart_pbtn'] );
                        } else {
                            $wpcc_disable_addtocart_pbtn = 'off';
                        }
						
                        if(isset($_REQUEST['wpcc_del_shw']) && !empty($_REQUEST['wpcc_del_shw'])) {
                            $wpcc_del_shw = sanitize_text_field( $_REQUEST['wpcc_del_shw'] );
                        } else {
                            $wpcc_del_shw = 'off';
                        }

                          if(isset($_REQUEST['wpcc_cash_dilivery_shw']) && !empty($_REQUEST['wpcc_cash_dilivery_shw'])) {
                            $wpcc_cash_dilivery_shw = sanitize_text_field( $_REQUEST['wpcc_cash_dilivery_shw'] );
                        } else {
                            $wpcc_cash_dilivery_shw = 'off';
                        }


                        
                       
                       update_option( 'wpcc_btn_txt', sanitize_text_field( $_REQUEST['wpcc_btn_txt'])); 
                        update_option( 'wpcc_delivery_date_txt', sanitize_text_field( $_REQUEST['wpcc_delivery_date_txt']));
                        update_option( 'wpcc_enable_shipping_cost', sanitize_text_field( $wpcc_enable_shipping_cost ));
                        update_option( 'wpcc_cash_on_delivery_txt', sanitize_text_field( $_REQUEST['wpcc_cash_on_delivery_txt']));
                          update_option( 'wpcc_availability_label_txt', sanitize_text_field( $_REQUEST['wpcc_availability_label_txt']));
                          
                           if(isset($_REQUEST['wpcc_checkpincode']) && !empty($_REQUEST['wpcc_checkpincode'])) {
                            $wpcc_checkpincode = htmlentities( $_REQUEST['wpcc_checkpincode'] );
                        } else {
                             $wpcc_checkpincode = 'off';
                         }
                          
                       
                        //  update_option( 'wpcc_place_order_button_txt', sanitize_text_field( $_REQUEST['wpcc_place_order_button_txt']));
                        
                        update_option( 'wpcc_enable_checkpcode', sanitize_text_field( $wpcc_enable_checkpcode ));
                        update_option( 'wpcc_checkpcode_pos', sanitize_text_field( $_REQUEST['wpcc_checkpcode_pos']));
                        update_option( 'wpcc_box_bg_clr', sanitize_text_field( $_REQUEST['wpcc_box_bg_clr']));
                        update_option( 'wpcc_check_ibox_bg_clr', sanitize_text_field( $_REQUEST['wpcc_check_ibox_bg_clr']));
                        update_option( 'wpcc_bg_clr', sanitize_text_field( $_REQUEST['wpcc_btn_bg_clr']) );
                        update_option( 'wpcc_txt_clr', sanitize_text_field( $_REQUEST['wpcc_btn_txt_clr']));
                        update_option( 'wpcc_cash_dilivery_shw', sanitize_text_field( $wpcc_cash_dilivery_shw ));
                        update_option( 'wpcc_del_shw', sanitize_text_field( $wpcc_del_shw ));
                        update_option( 'wpcc_checkpincode', sanitize_text_field( $wpcc_checkpincode ));
                        update_option( 'wpcc_hide_addtocart_sbtn', sanitize_text_field( $wpcc_hide_addtocart_sbtn ));
						   update_option( 'wpcc_disable_addtocart_pbtn', sanitize_text_field( $wpcc_disable_addtocart_pbtn ));
                    }
                }


                if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'wpcc_add_postcode') {
                    if(!isset( $_POST['WPCC_add_postcode_field'] ) || !wp_verify_nonce( $_POST['WPCC_add_postcode_field'], 'WPCC_add_postcode_action' )) {
                        
                        echo 'Sorry, your nonce did not verify.';
                        exit;

                    } else {

                        $pincode = sanitize_text_field( $_REQUEST['txtpincode']);
                        $city = sanitize_text_field( $_REQUEST['txtcity']);
                        $state = sanitize_text_field( $_REQUEST['txtstate']);
                        $ddate = sanitize_text_field( $_REQUEST['txtdelivery']);
                        $ship_amount = sanitize_text_field( $_REQUEST['txtshippingamount']);

                        if(isset($_POST['txtcod']) && $_POST['txtcod'] != '') {
                            $cod = sanitize_text_field($_POST['txtcod']);
                        } else {
                            $cod = '0';
                        }
                   $cod_amount = sanitize_text_field( $_REQUEST['txtcodamount']);
                   
                        $cntSQL = "SELECT count(*) as count FROM {$tablename} where wpcc_pincode='".$pincode."'";
                        $record = $wpdb->get_results($cntSQL, OBJECT);
                        
                        if($record[0]->count == 0) {
                            if(!empty($pincode) && !empty($city) && !empty($state)  ) {
                                $data=array(
                                    'wpcc_pincode'  => $pincode,
                                    'wpcc_city'     => $city, 
                                    'wpcc_state'    => $state,
                                    'wpcc_ddate'    => $ddate,
                                    'wpcc_ship_amount' => $ship_amount,
                                    'wpcc_cod'      => $cod,
                                    'wpcc_cod_amount'      => $cod_amount

                                );
                                $wpdb->insert( $tablename, $data);
                                wp_redirect(admin_url('admin.php?page=post-code&add=success'));
                                exit;
                            }
                        } else {
                            wp_redirect(admin_url('admin.php?page=post-code&add=exists&txtpincode='.$pincode.'&txtcity='.$city.'&txtstate='.$state.'&txtdelivery='.$ddate.'&txtcod='.$cod.'&txtcodamount='.$cod_amount));
                            exit;
                        }
                    }
                }


                if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'wpcc_update_postcode') {
                    if(!isset( $_POST['WPCC_update_postcode_field'] ) || !wp_verify_nonce( $_POST['WPCC_update_postcode_field'], 'WPCC_update_postcode_action' )) {
                        
                        echo 'Sorry, your nonce did not verify.';
                        exit;

                    } else {

                        $pincode_exists = 'false';
                        $id = sanitize_text_field( $_REQUEST['txtid']);
                        $pincode = sanitize_text_field( $_REQUEST['txtpincode']);
                        $city = sanitize_text_field( $_REQUEST['txtcity']);
                        $state = sanitize_text_field( $_REQUEST['txtstate']);
                        $ddate = sanitize_text_field( $_REQUEST['txtdelivery']);
                        $ship_amount = sanitize_text_field( $_REQUEST['txtshippingamount']);

                        if(isset($_POST['txtcod']) && $_POST['txtcod'] != '') {
                            $cod = sanitize_text_field($_POST['txtcod']);
                        } else {
                            $cod = '0';
                        }
                        $cod_amount = sanitize_text_field( $_REQUEST['txtcodamount']);
                        
                        $cntSQL = "SELECT * FROM {$tablename} where id='".$id."'";
                        $record = $wpdb->get_results($cntSQL, OBJECT);

                        $cntSQL_new = "SELECT count(*) as count FROM {$tablename} where wpcc_pincode='".$pincode."'";
                        $record_new = $wpdb->get_results($cntSQL_new, OBJECT);

                        $current_pincode = $record[0]->wpcc_pincode;
                        $count_new = $record_new[0]->count;
                        
                        if($pincode != $current_pincode) {
                            if($count_new > 0 ) {
                                $pincode_exists = 'true';
                            }
                        }


                        if($pincode_exists == 'false') {
                            if(!empty($pincode) && !empty($city) && !empty($state)  ) {
                                $data=array(
                                    'wpcc_pincode'  => $pincode,
                                    'wpcc_city'     => $city, 
                                    'wpcc_state'    => $state,
                                    'wpcc_ddate'    => $ddate,
                                    'wpcc_ship_amount' => $ship_amount,
                                    'wpcc_cod'      => $cod,
                                    'wpcc_cod_amount'      => $cod_amount

                                );
                                $condition=array(
                                    'id'=>$id
                                );

                                $wpdb->update($tablename, $data, $condition);
                                wp_redirect(admin_url('admin.php?page=post-code&action=oc_edit&id='.$id.'&update=success'));
                                exit;
                            }
                        } else {
                            wp_redirect(admin_url('admin.php?page=post-code&action=oc_edit&id='.$id.'&update=exists'));
                            exit;
                        }
                    }
                }


                if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'wpcc_import_postcodes') {
                    if(!isset( $_POST['WPCC_import_postcodes_field'] ) || !wp_verify_nonce( $_POST['WPCC_import_postcodes_field'], 'WPCC_import_postcodes_action' )) {
                        
                        echo 'Sorry, your nonce did not verify.';
                        exit;

                    } else {

                        if(isset($_POST['butimport'])) {

                            // File extension
                            $extension = pathinfo($_FILES['import_file']['name'], PATHINFO_EXTENSION);

                            // If file extension is 'csv'
                            if(!empty($_FILES['import_file']['name']) && $extension == 'csv') {

                                $totalInserted = 0;
                         
                                // Open file in read mode
                                $csvFile = fopen($_FILES['import_file']['tmp_name'], 'r');
                                fgetcsv($csvFile); // Skipping header row

                                // Read file
                                while(($csvData = fgetcsv($csvFile)) !== FALSE) {
                                    $csvData = array_map("utf8_encode", $csvData);

                                    // Assign value to variables
                                    $pincode    = trim($csvData[0]);
                                    $city       = trim($csvData[1]);
                                    $state      = trim($csvData[2]);
                                    $ddate      = trim($csvData[3]);
                                    $ship_amount      = trim($csvData[4]);
                                    $cod        = trim($csvData[5]);
                                    $cod_amount        = trim($csvData[6]);
                              
                                    $cntSQL = "SELECT count(*) as count FROM {$tablename} where wpcc_pincode='".$pincode."'";
                                    $record = $wpdb->get_results($cntSQL, OBJECT);

                                    if($record[0]->count == 0) {

                                        // Check if variable is empty or not
                                        if($pincode!="" ) {
                                            // Insert Record
                                            $wpdb->insert($tablename, array(
                                               'wpcc_pincode'   => $pincode,
                                               'wpcc_city'      => $city,
                                               'wpcc_state'     => $state,
                                               'wpcc_ddate'     => $ddate,
                                               'wpcc_ship_amount' => $ship_amount,
                                               'wpcc_cod'       => $cod,
                                               'wpcc_cod_amount'      => $cod_amount
                                            ));
                                            if($wpdb->insert_id > 0) {
                                               $totalInserted++;
                                            }
                                        }
                                    }
                                }
                                wp_redirect(admin_url('admin.php?page=post-code-import&import=success&records='.$totalInserted));
                                exit;
                            } else {
                                wp_redirect(admin_url('admin.php?page=post-code-import&import=error'));
                                exit;
                            }
                        }
                    }
                }


                if (isset($_REQUEST['action']) && $_REQUEST['action'] == "wpcc_delete") {
                    if( wp_verify_nonce( $_GET['_wpnonce'], 'my_nonce' ) ) {
                        $pincode = sanitize_text_field($_REQUEST['id']);
                        $sql = "DELETE FROM $tablename WHERE id='".$pincode."'";
                        $wpdb->query($sql);
                        wp_redirect(admin_url('admin.php?page=post-code&delete=success'));
                        exit;
                    } else {
                        echo 'Sorry, your nonce did not verify.';
                        exit;
                    }
                }

                if(isset($_REQUEST['all_record_delete']) ){
                        $sql = "DELETE FROM $tablename";
                        $wpdb->query($sql);
                        wp_redirect(admin_url('admin.php?page=post-code&delete=success'));
                        exit;
                }
            }
        }

        function WPCC_support_and_rating_notice() {
            $screen = get_current_screen();
             //print_r($screen);
            if( 'post-code' == $screen->parent_base) {
                ?>
                <div class="wpcc_mainnn_rantiong">
                   
                    <div class="wpcc_support_notice">
                        <div class="wpcc_rtusnoti_left">
                            <h3>Having Issues?</h3>
                            <label>You can contact us at work@codevyne.com</label>
                           
                            </a>
                        </div>
                       
                    </div>
                </div>
                <div class="wpcc_donate_main">
                   <img src="<?php echo WPCC_PLUGIN_DIR;?>/includes/images/coffee.svg">
                   <h3>Buy me a Coffee !</h3>
                   <p>If you like this plugin, buy me a coffee and help support this plugin !</p>
                   <div class="wpcc_donate_form">
                      <a class="button button-primary ocwg_donate_btn" href="https://www.paypal.com/paypalme/pradeepku041/" data-link="https://www.paypal.com/paypalme/pradeepku041/" target="_blank">Buy me a coffee !</a>
                   </div>
                </div>
                <?php
            }
        }
        
      
function check_pincode_product_settings_tabs( $tabs ){
 

 
	$tabs['check_pincode'] = array(
		'label'    => 'Check Pincode/Zipcode',
		'target'   => 'check_pincode_product_data',
		'class'    => array('check_pincode'),
		'priority' => 21,
	);
	return $tabs;
 
}
        
        // custom meta code

function woocommerce_product_custom_fields()
{
   global $woocommerce, $post;
    echo '<div id="check_pincode_product_data" class="panel woocommerce_options_panel hidden">';
    
    //Custom Product Number Field
    woocommerce_wp_text_input(
        array(
            'id' => '_product_handling_time_field',
           'value'  => get_post_meta( get_the_ID(), '_product_handling_time_field', true ),
            'placeholder' => 'Enter Product Handling Time',
            'label' => __('Product Handling Time', 'woocommerce'),
            'description'       => 'Days',
            'type' => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min' => '0'
            ),
        )
    );
    
   
    echo '</div>';
}

function woocommerce_product_handling_time_fields_save($post_id)
{
// Custom Product Number Field
    $woocommerce_product_handling_time_field = $_POST['_product_handling_time_field'];
    if (!empty($woocommerce_product_handling_time_field)){
        update_post_meta($post_id, '_product_handling_time_field', esc_attr($woocommerce_product_handling_time_field));
    }
}

function check_pincode_css_icon(){
	echo '<style>
	#woocommerce-product-data ul.wc-tabs li.misha_options.misha_tab a:before{
		content: "\f230";
	}
	</style>';
}

  
        function init() {
            add_action( 'admin_menu', array($this, 'WPCC_admin_menu') );
            add_action( 'init', array($this, 'WPCC_save_options') );
            add_action( 'admin_notices', array($this, 'WPCC_support_and_rating_notice' ));
            if( get_option('wpcc_enable_checkpcode', 'on') == 'on' ) {
              add_filter('woocommerce_product_data_tabs', array($this,'check_pincode_product_settings_tabs' ));
            add_action('woocommerce_product_data_panels', array($this,'woocommerce_product_custom_fields'));
            // Save Fields
            add_action('woocommerce_process_product_meta',  array($this,'woocommerce_product_handling_time_fields_save'));
            add_action('admin_head', array($this,'check_pincode_css_icon'));
            }

        } 


        public static function instance() {
            if (!isset(self::$instance)) {
                self::$instance = new self();
                self::$instance->init();
            }
            return self::$instance;
        }
    }
    WPCC_menu::instance();
}


class WPCC_List_Table extends WP_List_Table {
    public function __construct() {
        parent::__construct(
            array(
                'singular' => 'singular_form',
                'plural'   => 'plural_form',
                'ajax'     => false
            )
        );
    }


    public function prepare_items() {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();
        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );
        $perPage = 10;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
        $this->process_bulk_action();
    }
   

    public function get_columns() {
        $columns = array(
            'cb'        => '<input type="checkbox" />',
            'pincode'     => 'Pincode',
            'city'        => 'City',
            'state'       => 'State',
            'date'        => 'Delivery Day',
            'shipping_amount' =>'Shipping Amount',
            'cod'        => 'Cash on Delivery',
            'cod_amount'        => 'COD Amount',
        );
        return $columns;
    }
   

    public function get_hidden_columns() {
        return array();
    }
  

    public function get_sortable_columns() {
        return array('pincode' => array('pincode', false));
    }


    private function table_data() {
        $data = array();
        global $wpdb;
        $tablename = $wpdb->prefix.'wpcc_postcode';
        $wpcc_records = $wpdb->get_results( "SELECT * FROM $tablename" );
        foreach ($wpcc_records as $wpcc_record) {

            if($wpcc_record->wpcc_cod == '1') {
                $cod = 'Yes';
            } else {
                $cod = 'No';
            }

            $data[] = array(
                'id'          => $wpcc_record->id,
                'pincode'     => $wpcc_record->wpcc_pincode,
                'city'        => $wpcc_record->wpcc_city,
                'state'       => $wpcc_record->wpcc_state,
                'date'        => $wpcc_record->wpcc_ddate,
                'shipping_amount' =>$wpcc_record->wpcc_ship_amount,
                'cod'         => $cod,
                'cod_amount'   => $wpcc_record->wpcc_cod_amount,
            );
        }
        return $data;
    }
   

    public function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'id':
                return $item['id'];
            case 'pincode':
                return $item['pincode'];
            case 'city':
                return $item['city'];
            case 'state':
                return $item['state'];
            case 'date':
                return $item['date'];
            case 'shipping_amount':
                return $item['shipping_amount'];
            case 'cod':
                return $item['cod'];
            case 'cod_amount':
                return $item['cod_amount'];
            default:
                return print_r( $item, true ) ;
        }
    }


    private function sort_data( $a, $b ) {
        // Set defaults
        $orderby = 'pincode';
        $order = 'asc';
        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby'])) {
            $orderby = sanitize_text_field($_GET['orderby']);
        }
        // If order is set use this as the order
        if(!empty($_GET['order'])) {
            $order = sanitize_text_field($_GET['order']);
        }
        $result = strcmp( $a[$orderby], $b[$orderby] );
        if($order === 'asc') {
            return $result;
        }
        return -$result;
    }


    public function get_bulk_actions() {
        return array(
            'delete' => __( 'Delete', 'wpcc' ),
        );
    }


    function column_cb($item) {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />', $item['id']
        );    
    }

    function WPCC_recursive_sanitize_text_field($array) {
         
        foreach ( $array as $key => &$value ) {
            if ( is_array( $value ) ) {
                $value = $this->WPCC_recursive_sanitize_text_field($value);
            }else{
                $value = sanitize_text_field( $value );
            }
        }
        return $array;
    }



    public function process_bulk_action() {
        global $wpdb;
        $tablename = $wpdb->prefix.'wpcc_postcode';
        // security check!
        if ( isset( $_POST['_wpnonce'] ) && ! empty( $_POST['_wpnonce'] ) ) {
            $nonce  = filter_input( INPUT_POST, '_wpnonce', FILTER_SANITIZE_STRING );
            $action = 'bulk-' . $this->_args['plural'];

            if ( ! wp_verify_nonce( $nonce, $action ) )
                wp_die( 'Nope! Security check failed!' );
        }

        $action = $this->current_action();
        switch ( $action ) {

            case 'delete':
                $ids = isset($_REQUEST['id']) ? $this->WPCC_recursive_sanitize_text_field($_REQUEST['id']) : array();
                if (is_array($ids)) $ids = implode(',', $ids);

                    if (!empty($ids)) {
                        $wpdb->query("DELETE FROM $tablename WHERE id IN($ids)");
                    }

                wp_redirect( $_SERVER['HTTP_REFERER'] );

                break;

            default:
                // do nothing or something else
                return;
                break;
        }
        return;
    }


    function column_pincode($item) {

        $delete_url = wp_nonce_url( admin_url().'?page=post-code&action=wpcc_delete&id='.$item['id'], 'my_nonce' );
        
        $actions = array(
            'edit'      => sprintf('<a href="?page=add-post-code&action=%s&id=%s">Edit</a>','oc_edit',$item['id']),
            'delete'    => '<a href="'.$delete_url.'">Delete</a>',
        );

        return sprintf('%1$s %2$s', $item['pincode'], $this->row_actions($actions) );
    }
    

}