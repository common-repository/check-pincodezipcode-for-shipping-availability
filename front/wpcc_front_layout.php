<?php

if (!defined('ABSPATH'))
    exit;

if (!class_exists('WPCC_front')) {

    class WPCC_front {

        protected static $instance;
        function WPCC_before_add_to_cart_btn() {

            $box_backgrond_clr = get_option('wpcc_box_bg_clr', '#f2f2f2');
            $wpcc_check_ibox_bg_clr = get_option( 'wpcc_check_ibox_bg_clr', '#ffffff' );
          
            $backgrond_clr = get_option('wpcc_bg_clr', '#8bc34a');
            $text_clr = get_option('wpcc_txt_clr', '#ffffff');
             $cash_on_delivary_text= get_option('wpcc_cash_on_delivery_txt', 'Cash on delivery');
             $check_availability_text= get_option('wpcc_availability_label_txt', 'Check availability at');
              $serviceable_text= get_option('wpcc_serviceable_txt', 'Shipping available at your location.');
              $delivery_text= get_option('wpcc_delivery_date_txt', 'Estimated delivery in');

            $text = get_option('wpcc_btn_txt', 'Check');
            $not_serviceable_text = get_option('wpcc_not_serviceable_txt', 'Oops! We are not currently servicing at your location.');
             $edit_icon = WPCC_PLUGIN_DIR.'/includes/images/icon-edit.svg';
           
            ?>
            <div class="wpccc_maindiv" style="background-color: <?php echo $box_backgrond_clr; ?>;">
                <input type="hidden" name="handling_time" id="handling_time" value="<?php if(get_post_meta( get_the_ID(), '_product_handling_time_field', true )){
                                       echo $handling_time=get_post_meta( get_the_ID(), '_product_handling_time_field', true );
                                   }else{ echo "0";}?>">
                <h3><?php echo $check_availability_text;?> <span class="wpcc_avaicode"> <?php if(isset($_COOKIE['wpcc_postcode']) && $_COOKIE['wpcc_postcode'] != "no") {?>
              <?php echo sanitize_text_field($_COOKIE['wpcc_postcode']);?>   <?php } ?></span> <a class="wpcccheckbtn" ><img src="<?php echo $edit_icon;?>"></a>
            </h3>
                <div class="wpcc_checkcode" style="display: <?php if(isset($_COOKIE['wpcc_postcode']) && $_COOKIE['wpcc_postcode'] != "no") { echo "block"; } else { echo "none"; } ?>;">
                    <div class="response_pin">
                        <?php 
                            if(isset($_COOKIE['wpcc_postcode'])) {
                                global $wpdb;
                                $tablename=$wpdb->prefix.'wpcc_postcode';
                                $cntSQL = "SELECT * FROM {$tablename} where wpcc_pincode='".sanitize_text_field($_COOKIE['wpcc_postcode'])."'";
                                $record = $wpdb->get_results($cntSQL, OBJECT);
                                $totalrec = count($record);
                                if ($totalrec == 1) {

                                    $deltxt = "";
                                    $date = $record[0]->wpcc_ddate;
                                    $cod = $record[0]->wpcc_cod;
                                 $handling_time=0;
                                   if(get_post_meta( get_the_ID(), '_product_handling_time_field', true )){
                                       $handling_time=get_post_meta( get_the_ID(), '_product_handling_time_field', true );
                                   }
                                   $ttldeliveytime=$date+$handling_time;
                                    $string = "+".$ttldeliveytime." days";

                                    $deliverydate = Date('jS M', strtotime($string));
                                    $dayofweek = date('D', strtotime($string));
                                    $deliverydate = $dayofweek.', '.$deliverydate;
                                    

                                    $showdate = get_option('wpcc_del_shw', 'on');
                                     $wpcc_cash_dilivery_shw = get_option('wpcc_cash_dilivery_shw', 'on');
                                    $cash_on_delivary_text= get_option('wpcc_cash_on_delivery_txt', 'Cash On Delivery');
                                    $del_avail_icon = WPCC_PLUGIN_DIR.'/includes/images/true.png';

                                    if($cod == 1) {
                                        $cod_avail = 'Available';
                                        $cod_avail_icon = WPCC_PLUGIN_DIR.'/includes/images/true.png';
                                    } else {
                                        $cod_avail = 'Not Available';
                                        $cod_avail_icon = WPCC_PLUGIN_DIR.'/includes/images/false.png';
                                    }

                                    $deltxt = "<div class='wpcc_avacod'><p>".$cash_on_delivary_text." <span>".$cod_avail."</span></p></div>";

                                   echo '<div class="wpcc_serviceavaitxt"><span class="serviceavailtxt">'.$serviceable_text.'</span></div>';

                                    if($showdate == "on") {

                                        echo '<div class="wpcc_avaitxt"><span class="wpcc_tficon"><img src="'.$del_avail_icon.'"></span><span class="wpcc_delicons"><svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                             width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                                             preserveAspectRatio="xMidYMid meet">

                                            <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                            fill="#000000" stroke="none">
                                            <path d="M558 4059 c-68 -35 -78 -71 -78 -279 l0 -180 -105 0 c-86 0 -113 -4
                                            -145 -20 -45 -23 -80 -80 -80 -130 0 -50 35 -107 80 -130 37 -19 58 -20 449
                                            -20 345 0 417 -2 449 -15 96 -39 101 -180 9 -249 -28 -21 -40 -21 -530 -26
                                            -456 -5 -505 -7 -534 -23 -38 -20 -73 -82 -73 -127 0 -50 35 -107 80 -130 38
                                            -19 58 -20 747 -20 l708 0 39 -23 c100 -57 100 -197 0 -254 l-39 -23 -708 0
                                            c-689 0 -709 -1 -747 -20 -45 -23 -80 -80 -80 -130 0 -50 35 -107 80 -130 35
                                            -18 59 -20 220 -20 l180 0 0 -240 c0 -352 0 -352 278 -360 l173 -5 22 -65 c30
                                            -90 69 -152 137 -220 224 -224 586 -224 810 0 68 68 107 130 137 220 l22 65
                                            761 0 761 0 22 -65 c30 -90 69 -152 137 -220 224 -224 586 -224 810 0 68 68
                                            107 130 137 220 l22 65 153 5 c176 6 205 16 238 80 19 38 20 58 20 538 0 542
                                            -2 562 -57 665 -36 64 -119 139 -197 176 -125 60 -133 61 -795 61 l-603 0 -40
                                            22 c-79 45 -78 36 -78 563 l0 465 -1377 0 c-1352 -1 -1379 -1 -1415 -21z
                                            m1052 -2184 c92 -46 160 -153 160 -250 0 -97 -68 -204 -159 -250 -121 -61
                                            -296 1 -364 129 -31 58 -31 184 0 242 30 56 106 121 162 139 57 18 155 14 201
                                            -10z m2650 0 c92 -46 160 -153 160 -250 0 -97 -68 -204 -159 -250 -121 -61
                                            -296 1 -364 129 -31 58 -31 184 0 242 30 56 106 121 162 139 57 18 155 14 201
                                            -10z"/>
                                            <path d="M3650 3690 l0 -360 410 0 c226 0 410 3 410 6 0 13 -125 210 -184 289
                                            -118 159 -233 260 -382 334 -63 31 -227 91 -250 91 -2 0 -4 -162 -4 -360z"/>
                                            </g>
                                            </svg></span>';
      if(($ttldeliveytime-1) >0){
                             $deliverydays=($ttldeliveytime-1)." Days";
                        }else{
                             $deliverydays= "Today";
                        }
                        
                        if($ttldeliveytime>2){
                            $deliverydaystext ='Your product will be delivered in '.($ttldeliveytime-2).' to '.($ttldeliveytime-1).' days.';
                        }elseif($ttldeliveytime>1){
                             $deliverydaystext ='Your product will be delivered in '.$ttldeliveytime.' days.';
                        }else{
                            $deliverydaystext = 'Your product will be delivered by today';
                        }
                       
                                        echo '<div class="wpcc_avaddate"><p>'.$delivery_text.' '.$deliverydays.' <span> ('.$deliverydate.')</span></p></div></div>';
                                    }
                                    if($wpcc_cash_dilivery_shw == "on") {   
                                        echo '<div class="wpcc_dlvrytxt"><span class="wpcc_tficon"><img src="'.$cod_avail_icon.'"></span><span class="wpcc_delicons">
<?xml version="1.0" encoding="iso-8859-1"?>
<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
    <g>
        <path d="M172.55,391.902c-0.13-0.64-0.32-1.27-0.57-1.88c-0.25-0.6-0.56-1.18-0.92-1.72c-0.36-0.55-0.78-1.06-1.24-1.52
            c-0.46-0.46-0.97-0.88-1.52-1.24c-0.54-0.36-1.12-0.67-1.73-0.92c-0.6-0.25-1.23-0.45-1.87-0.57c-1.29-0.26-2.62-0.26-3.9,0
            c-0.64,0.12-1.27,0.32-1.88,0.57c-0.6,0.25-1.18,0.56-1.72,0.92c-0.55,0.36-1.06,0.78-1.52,1.24c-0.46,0.46-0.88,0.97-1.24,1.52
            c-0.37,0.54-0.67,1.12-0.92,1.72c-0.25,0.61-0.45,1.24-0.57,1.88c-0.13,0.64-0.2,1.3-0.2,1.95c0,0.65,0.07,1.31,0.2,1.95
            c0.12,0.64,0.32,1.27,0.57,1.87c0.25,0.61,0.55,1.19,0.92,1.73c0.36,0.55,0.78,1.06,1.24,1.52c0.46,0.46,0.97,0.88,1.52,1.24
            c0.54,0.361,1.12,0.671,1.72,0.921c0.61,0.25,1.24,0.45,1.88,0.57c0.64,0.13,1.3,0.2,1.95,0.2c0.65,0,1.31-0.07,1.95-0.2
            c0.64-0.12,1.27-0.32,1.87-0.57c0.61-0.25,1.19-0.561,1.73-0.921c0.55-0.36,1.06-0.78,1.52-1.24c0.46-0.46,0.88-0.97,1.24-1.52
            c0.36-0.54,0.67-1.12,0.92-1.73c0.25-0.6,0.44-1.23,0.57-1.87s0.2-1.3,0.2-1.95S172.68,392.542,172.55,391.902z"/>
    </g>
</g>
<g>
    <g>
        <path d="M459.993,394.982c-0.039-0.1-0.079-0.199-0.121-0.297c-9.204-21.537-30.79-29.497-56.336-20.772l-69.668,19.266
            c-4.028-12.198-14.075-22.578-28.281-27.85c-0.088-0.032-0.176-0.064-0.265-0.094l-76.581-25.992
            c-6.374-8.239-26.34-29.321-63.723-29.321c-26.125,0-49.236,17.922-62.458,37.457H10c-5.523,0-10,4.477-10,10v126.077
            c0,5.523,4.477,10,10,10h59.457c5.523,0,10-4.477,10-10v-8.634h27.883c5.523,0,10-4.477,10-10v-2.878
            c16.254,1.418,21.6,4.501,36.528,13.109c11.48,6.62,28.831,16.625,60.077,30.674c0.145,0.065,0.292,0.127,0.439,0.185
            c5.997,2.359,17.72,6.065,32.173,6.065c10.06,0,21.445-1.797,33.131-7.094l153.991-55.136c0.274-0.098,0.544-0.208,0.808-0.33
            C449.204,442.646,471.135,423.563,459.993,394.982z M59.457,473.455H20V367.378h39.457V473.455z M97.34,454.821H79.457v-87.443
            H97.34V454.821z M426.496,431.074l-153.922,55.111c-0.135,0.048-0.318,0.12-0.451,0.174c-0.135,0.055-0.27,0.113-0.403,0.174
            c-21.437,9.852-41.814,3.954-49.8,0.849c-30.182-13.581-46.291-22.87-58.061-29.657c-16.364-9.436-24.249-13.984-46.519-15.823
            V361.36c9.479-15.536,27.861-31.439,47.679-31.439c33.986,0,48.387,22.105,48.953,22.997c1.221,1.986,3.098,3.483,5.305,4.232
            l79.475,26.974c12.693,4.764,19.401,15.634,16.318,26.474c-1.423,5.006-4.711,9.158-9.257,11.691
            c-4.507,2.511-9.717,3.132-14.683,1.758l-89.593-28.392c-5.268-1.669-10.886,1.247-12.554,6.512
            c-1.669,5.265,1.247,10.885,6.512,12.554l89.749,28.441c0.095,0.03,0.19,0.059,0.286,0.086c3.583,1.019,7.231,1.523,10.857,1.523
            c6.638,0,13.203-1.691,19.161-5.011c9.213-5.133,15.875-13.547,18.759-23.692c0.23-0.81,0.434-1.62,0.611-2.43l75.083-20.8
            c10.844-3.704,25.079-5.039,31.417,9.558C447.978,419.533,430.928,428.96,426.496,431.074z"/>
    </g>
</g>
<g>
    <g>
        <path d="M359.06,131.543c-0.13-0.64-0.32-1.27-0.58-1.88c-0.25-0.6-0.55-1.18-0.92-1.72c-0.36-0.55-0.78-1.06-1.24-1.52
            c-0.46-0.46-0.97-0.88-1.52-1.24c-0.54-0.36-1.12-0.67-1.72-0.92c-0.61-0.25-1.24-0.45-1.87-0.57c-1.29-0.26-2.62-0.26-3.91,0
            c-0.64,0.12-1.27,0.32-1.87,0.57c-0.61,0.25-1.19,0.56-1.73,0.92c-0.55,0.36-1.06,0.78-1.52,1.24c-0.46,0.46-0.88,0.97-1.24,1.52
            c-0.36,0.54-0.67,1.12-0.92,1.72c-0.25,0.61-0.45,1.24-0.57,1.88c-0.13,0.64-0.2,1.3-0.2,1.95c0,0.65,0.07,1.31,0.2,1.95
            c0.12,0.64,0.32,1.27,0.57,1.87c0.25,0.61,0.56,1.19,0.92,1.73c0.36,0.55,0.78,1.06,1.24,1.52c0.46,0.46,0.97,0.88,1.52,1.24
            c0.54,0.36,1.12,0.67,1.73,0.92c0.6,0.25,1.23,0.44,1.87,0.57s1.3,0.2,1.95,0.2c0.65,0,1.31-0.07,1.96-0.2
            c0.63-0.13,1.26-0.32,1.87-0.57c0.6-0.25,1.18-0.56,1.72-0.92c0.55-0.36,1.06-0.78,1.52-1.24c0.46-0.46,0.88-0.97,1.24-1.52
            c0.37-0.54,0.67-1.12,0.92-1.73c0.26-0.6,0.45-1.23,0.58-1.87c0.13-0.64,0.19-1.3,0.19-1.95
            C359.25,132.843,359.19,132.183,359.06,131.543z"/>
    </g>
</g>
<g>
    <g>
        <path d="M502,33.891h-59.457c-5.523,0-10,4.477-10,10v8.634H404.66c-5.523,0-10,4.477-10,10v2.878
            c-16.254-1.419-21.6-4.501-36.527-13.109c-11.48-6.62-28.831-16.625-60.078-30.674c-0.145-0.066-0.291-0.127-0.44-0.185
            c-10.171-4.002-36.828-11.876-65.299,1.027l-40.24,14.408L158.157,2.952c-3.905-3.905-10.237-3.905-14.142,0L32.657,114.309
            c-3.602,3.603-4.293,9.85,0,14.143l190.287,190.287c3.045,3.046,10.175,3.967,14.143,0l101.665-101.664
            c2.643,0.228,5.386,0.351,8.229,0.351c26.126,0,49.236-17.922,62.457-37.456H502c5.523,0,10-4.477,10-10V43.891
            C512,38.368,507.523,33.891,502,33.891z M151.085,24.165l22.792,22.792c-6.775,4.19-14.608,6.432-22.792,6.432
            c-8.185,0-16.017-2.241-22.792-6.432L151.085,24.165z M76.663,144.173L53.871,121.38l22.792-22.792
            c4.19,6.775,6.432,14.608,6.432,22.792C83.095,129.564,80.854,137.397,76.663,144.173z M230.016,297.525l-22.788-22.788
            c13.913-8.586,31.661-8.586,45.575,0L230.016,297.525z M267.211,260.331c-22.098-16.03-52.292-16.03-74.39,0L91.07,158.579
            c7.809-10.74,12.025-23.641,12.025-37.199c0-13.559-4.215-26.459-12.025-37.199l22.817-22.816
            c10.74,7.809,23.64,12.025,37.199,12.025c13.559,0,26.459-4.216,37.199-12.025l21.629,21.629
            c-4.667,0.689-9.218,2.227-13.462,4.592c-7.168,3.994-12.792,9.975-16.294,17.211c-11.28,2.089-21.723,7.55-29.915,15.741
            c-22.225,22.226-22.225,58.389,0.001,80.615c11.112,11.112,25.709,16.669,40.307,16.669c14.597,0,29.195-5.556,40.308-16.669
            c7.23-7.23,12.295-16.116,14.832-25.8l33.764,11.459c-3.801,17.608,0.092,36.132,10.593,50.682L267.211,260.331z M206.413,162.018
            c0.088,0.032,0.176,0.064,0.265,0.094l19.996,6.787c-1.51,6.815-4.927,13.081-9.957,18.112c-14.428,14.426-37.904,14.428-52.33,0
            c-14.428-14.427-14.428-37.902,0-52.33c3.48-3.482,7.587-6.203,12.062-8.048C178.295,141.995,189.356,155.688,206.413,162.018z
             M304.457,223.084c-3.86-6.29-6.044-13.469-6.389-20.796c4.79,3.463,10.644,6.856,17.636,9.549L304.457,223.084z M394.659,165.983
            c-9.478,15.538-27.86,31.441-47.678,31.441c-3.708,0-7.183-0.264-10.432-0.734c-0.013-0.002-0.026-0.004-0.039-0.006
            c-21.596-3.137-33.213-15.411-37.042-20.271c-0.204-0.3-1.073-1.437-1.202-1.626c-1.165-2.082-3.075-3.756-5.511-4.583
            l-79.508-26.985c-12.688-4.762-19.395-15.627-16.321-26.463c0.002-0.007,0.004-0.014,0.006-0.021
            c0.003-0.008,0.005-0.017,0.007-0.025c1.429-4.99,4.711-9.129,9.247-11.656c4.506-2.511,9.715-3.134,14.683-1.757l89.593,28.391
            c5.266,1.671,10.886-1.247,12.554-6.512c1.668-5.265-1.247-10.885-6.512-12.554l-71.255-22.58l-0.622-0.622
            c-0.006-0.006-0.012-0.013-0.019-0.019l-36.89-36.89l31.708-11.354c0.107-0.039,0.239-0.088,0.345-0.131
            c0.027-0.011,0.079-0.031,0.105-0.042c0.136-0.055,0.27-0.113,0.403-0.174c21.436-9.852,41.812-3.955,49.799-0.849
            c30.183,13.581,46.293,22.87,58.063,29.657c16.364,9.437,24.249,13.984,46.518,15.823V165.983z M432.543,159.968H414.66V72.525
            h17.883V159.968z M492,159.968h-39.457V53.891H492V159.968z"/>
    </g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
</span>'.$deltxt.'</div><p class="deliverytime">'.$deliverydaystext.'</p>';
                                    }
                                } else {
                                    echo '<span class="notavailable">'.$not_serviceable_text.'</span>';
                                }
                            } 
                        ?>
                    </div>
                     </div>
                <div class="wpcc_cookie_check_div" style="display: <?php if(isset($_COOKIE['wpcc_postcode'])  && $_COOKIE['wpcc_postcode'] != "no") { echo "none"; } else { echo "flex"; } ?>;background-color: <?php echo $wpcc_check_ibox_bg_clr; ?>;">

                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000" preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                        fill="<?php echo $backgrond_clr; ?>" stroke="none">
                            <path d="M2430 5114 c-229 -26 -360 -54 -508 -109 -392 -147 -720 -416 -943
                            -775 -210 -339 -307 -778 -259 -1170 78 -631 528 -1501 1274 -2465 176 -228
                            403 -501 455 -548 69 -62 153 -62 222 0 52 47 279 320 455 548 671 867 1102
                            1655 1238 2267 35 157 46 259 46 423 -1 480 -193 939 -540 1285 -286 287 -623
                            460 -1020 525 -94 15 -352 27 -420 19z m247 -925 c373 -50 682 -318 783 -679
                            27 -95 37 -286 21 -390 -47 -296 -241 -556 -516 -690 -162 -79 -328 -109 -497
                            -90 -132 15 -199 34 -313 90 -275 134 -469 394 -516 690 -16 104 -6 295 21
                            390 125 446 566 741 1017 679z"/>
                        </g>
                    </svg>
                   
                    <input type="text" name="wpcccheck" class="wpcccheck" value="<?php if(isset($_COOKIE['wpcc_postcode']) && sanitize_text_field($_COOKIE['wpcc_postcode']) != "no") { echo sanitize_text_field($_COOKIE['wpcc_postcode']); } ?>" style="background-color: <?php echo $wpcc_check_ibox_bg_clr; ?>;">
                    <input type="button" name="wpccbtn" class="wpccbtn" value="<?php echo $text; ?>" style="background-color: <?php echo $backgrond_clr; ?>;color: <?php echo $text_clr; ?>;">
                </div>
                <span class="wpcc_empty">Pincode field should not be empty!</span>
            </div>
            <?php    
        }


        function WPCC_check_location() {
            global $wpdb;
            $pincode = sanitize_text_field($_REQUEST['postcode']);
            $handlingTime = sanitize_text_field($_REQUEST['handlingTime']);
            
            $tablename=$wpdb->prefix.'wpcc_postcode';
            $cntSQL = "SELECT * FROM {$tablename} where wpcc_pincode='".$pincode."'";
            $record = $wpdb->get_results($cntSQL, OBJECT);
            $date = $record[0]->wpcc_ddate;
            $cod = $record[0]->wpcc_cod;
            $cod_amount = $record[0]->wpcc_cod_amount;
            $codtxt = "";
           
             $ttldeliveytime=$date+$handlingTime;
             $string = "+".$ttldeliveytime." days";
            
            $deliverydate = Date('jS M', strtotime($string));
            $dayofweek = date('D', strtotime($string));
            $deliverydate = $dayofweek.', '.$deliverydate;

            $totalrec = count($record);
            $showdate = get_option('wpcc_del_shw', 'on');
            $diableCartbtn = get_option('wpcc_disable_addtocart_pbtn', 'off');

            $del_avail_icon = WPCC_PLUGIN_DIR.'/includes/images/true.png';
            $cash_on_delivary_text= get_option('wpcc_cash_on_delivery_txt', 'Cash on delivery');
            $wpcc_cash_dilivery_shw = get_option('wpcc_cash_dilivery_shw', 'on');
            $serviceable_text= get_option('wpcc_serviceable_txt', 'Shipping available at your location');
            $delivery_text= get_option('wpcc_delivery_date_txt', 'Estimated delivery in');
            if($cod == 1) {
                $cod_avail = 'Available';
                $cod_avail_icon = WPCC_PLUGIN_DIR.'/includes/images/true.png';
            } else {
                $cod_avail = 'Not Available';
                $cod_avail_icon = WPCC_PLUGIN_DIR.'/includes/images/false.png';
            }
              $edit_icon = WPCC_PLUGIN_DIR.'/includes/images/icon-edit.svg';
          $codtxt = "<p>".$cash_on_delivary_text." <span>".$cod_avail."</span></p>";

            $data = array();
            $data = array(
                'pincode'      => $pincode,
                'deliverydate' => $deliverydate,
                'totalrec'     => $totalrec,
                'showdate'     => $showdate,
                'disablecartbtn' => $diableCartbtn
            );

            $avai_msg = '';
                        
            $expiry = strtotime('+7 day');
            setcookie('wpcc_postcode', $pincode, $expiry , COOKIEPATH, COOKIE_DOMAIN);
            setcookie('wpcc_handling', $handlingTime, $expiry , COOKIEPATH, COOKIE_DOMAIN);
            setcookie('wpcc_cod', $cod, $expiry , COOKIEPATH, COOKIE_DOMAIN);
            if($totalrec == 1) {
               
              
               $avai_msg .= '<div class="wpcc_serviceavailtext"><span class="serviceavailtxt">'.$serviceable_text.'</span></div></div>';

                if($showdate == "on") {
                    $avai_msg .= '<div class="wpcc_avaitxt"><span class="wpcc_tficon"><img src="'.$del_avail_icon.'"></span><span class="wpcc_delicons"><svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                         width="512.000000pt" height="512.000000pt" viewBox="0 0 512.000000 512.000000"
                         preserveAspectRatio="xMidYMid meet">

                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                        fill="#000000" stroke="none">
                        <path d="M558 4059 c-68 -35 -78 -71 -78 -279 l0 -180 -105 0 c-86 0 -113 -4
                        -145 -20 -45 -23 -80 -80 -80 -130 0 -50 35 -107 80 -130 37 -19 58 -20 449
                        -20 345 0 417 -2 449 -15 96 -39 101 -180 9 -249 -28 -21 -40 -21 -530 -26
                        -456 -5 -505 -7 -534 -23 -38 -20 -73 -82 -73 -127 0 -50 35 -107 80 -130 38
                        -19 58 -20 747 -20 l708 0 39 -23 c100 -57 100 -197 0 -254 l-39 -23 -708 0
                        c-689 0 -709 -1 -747 -20 -45 -23 -80 -80 -80 -130 0 -50 35 -107 80 -130 35
                        -18 59 -20 220 -20 l180 0 0 -240 c0 -352 0 -352 278 -360 l173 -5 22 -65 c30
                        -90 69 -152 137 -220 224 -224 586 -224 810 0 68 68 107 130 137 220 l22 65
                        761 0 761 0 22 -65 c30 -90 69 -152 137 -220 224 -224 586 -224 810 0 68 68
                        107 130 137 220 l22 65 153 5 c176 6 205 16 238 80 19 38 20 58 20 538 0 542
                        -2 562 -57 665 -36 64 -119 139 -197 176 -125 60 -133 61 -795 61 l-603 0 -40
                        22 c-79 45 -78 36 -78 563 l0 465 -1377 0 c-1352 -1 -1379 -1 -1415 -21z
                        m1052 -2184 c92 -46 160 -153 160 -250 0 -97 -68 -204 -159 -250 -121 -61
                        -296 1 -364 129 -31 58 -31 184 0 242 30 56 106 121 162 139 57 18 155 14 201
                        -10z m2650 0 c92 -46 160 -153 160 -250 0 -97 -68 -204 -159 -250 -121 -61
                        -296 1 -364 129 -31 58 -31 184 0 242 30 56 106 121 162 139 57 18 155 14 201
                        -10z"/>
                        <path d="M3650 3690 l0 -360 410 0 c226 0 410 3 410 6 0 13 -125 210 -184 289
                        -118 159 -233 260 -382 334 -63 31 -227 91 -250 91 -2 0 -4 -162 -4 -360z"/>
                        </g>
                        </svg></span>';
                        if(($ttldeliveytime-1) >0){
                             $deliverydays=($ttldeliveytime-1)." Days";
                        }else{
                             $deliverydays= "Today";
                        }
                        
                        if($ttldeliveytime>2){
                            $deliverydaystext ='Your product will be delivered in '.($ttldeliveytime-2).' to '.($ttldeliveytime-1).' days.';
                        }elseif($ttldeliveytime>1){
                             $deliverydaystext ='Your product will be delivered in '.$ttldeliveytime.' days.';
                        }else{
                            $deliverydaystext = 'Your product will be delivered by today';
                        }
                    $avai_msg .= '<div class="wpcc_avaddate"><p>'.$delivery_text.' '.$deliverydays.' <span> ('.$deliverydate.')</span></p></div></div>';
                }

                if($wpcc_cash_dilivery_shw == "on") {

                    $avai_msg .= '<div class="wpcc_dlvrytxt"><span class="wpcc_tficon"><img src="'.$cod_avail_icon.'"></span><span class="wpcc_delicons">
<?xml version="1.0" encoding="iso-8859-1"?>
<!-- Generator: Adobe Illustrator 19.0.0, SVG Export Plug-In . SVG Version: 6.00 Build 0)  -->
<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<g>
    <g>
        <path d="M172.55,391.902c-0.13-0.64-0.32-1.27-0.57-1.88c-0.25-0.6-0.56-1.18-0.92-1.72c-0.36-0.55-0.78-1.06-1.24-1.52
            c-0.46-0.46-0.97-0.88-1.52-1.24c-0.54-0.36-1.12-0.67-1.73-0.92c-0.6-0.25-1.23-0.45-1.87-0.57c-1.29-0.26-2.62-0.26-3.9,0
            c-0.64,0.12-1.27,0.32-1.88,0.57c-0.6,0.25-1.18,0.56-1.72,0.92c-0.55,0.36-1.06,0.78-1.52,1.24c-0.46,0.46-0.88,0.97-1.24,1.52
            c-0.37,0.54-0.67,1.12-0.92,1.72c-0.25,0.61-0.45,1.24-0.57,1.88c-0.13,0.64-0.2,1.3-0.2,1.95c0,0.65,0.07,1.31,0.2,1.95
            c0.12,0.64,0.32,1.27,0.57,1.87c0.25,0.61,0.55,1.19,0.92,1.73c0.36,0.55,0.78,1.06,1.24,1.52c0.46,0.46,0.97,0.88,1.52,1.24
            c0.54,0.361,1.12,0.671,1.72,0.921c0.61,0.25,1.24,0.45,1.88,0.57c0.64,0.13,1.3,0.2,1.95,0.2c0.65,0,1.31-0.07,1.95-0.2
            c0.64-0.12,1.27-0.32,1.87-0.57c0.61-0.25,1.19-0.561,1.73-0.921c0.55-0.36,1.06-0.78,1.52-1.24c0.46-0.46,0.88-0.97,1.24-1.52
            c0.36-0.54,0.67-1.12,0.92-1.73c0.25-0.6,0.44-1.23,0.57-1.87s0.2-1.3,0.2-1.95S172.68,392.542,172.55,391.902z"/>
    </g>
</g>
<g>
    <g>
        <path d="M459.993,394.982c-0.039-0.1-0.079-0.199-0.121-0.297c-9.204-21.537-30.79-29.497-56.336-20.772l-69.668,19.266
            c-4.028-12.198-14.075-22.578-28.281-27.85c-0.088-0.032-0.176-0.064-0.265-0.094l-76.581-25.992
            c-6.374-8.239-26.34-29.321-63.723-29.321c-26.125,0-49.236,17.922-62.458,37.457H10c-5.523,0-10,4.477-10,10v126.077
            c0,5.523,4.477,10,10,10h59.457c5.523,0,10-4.477,10-10v-8.634h27.883c5.523,0,10-4.477,10-10v-2.878
            c16.254,1.418,21.6,4.501,36.528,13.109c11.48,6.62,28.831,16.625,60.077,30.674c0.145,0.065,0.292,0.127,0.439,0.185
            c5.997,2.359,17.72,6.065,32.173,6.065c10.06,0,21.445-1.797,33.131-7.094l153.991-55.136c0.274-0.098,0.544-0.208,0.808-0.33
            C449.204,442.646,471.135,423.563,459.993,394.982z M59.457,473.455H20V367.378h39.457V473.455z M97.34,454.821H79.457v-87.443
            H97.34V454.821z M426.496,431.074l-153.922,55.111c-0.135,0.048-0.318,0.12-0.451,0.174c-0.135,0.055-0.27,0.113-0.403,0.174
            c-21.437,9.852-41.814,3.954-49.8,0.849c-30.182-13.581-46.291-22.87-58.061-29.657c-16.364-9.436-24.249-13.984-46.519-15.823
            V361.36c9.479-15.536,27.861-31.439,47.679-31.439c33.986,0,48.387,22.105,48.953,22.997c1.221,1.986,3.098,3.483,5.305,4.232
            l79.475,26.974c12.693,4.764,19.401,15.634,16.318,26.474c-1.423,5.006-4.711,9.158-9.257,11.691
            c-4.507,2.511-9.717,3.132-14.683,1.758l-89.593-28.392c-5.268-1.669-10.886,1.247-12.554,6.512
            c-1.669,5.265,1.247,10.885,6.512,12.554l89.749,28.441c0.095,0.03,0.19,0.059,0.286,0.086c3.583,1.019,7.231,1.523,10.857,1.523
            c6.638,0,13.203-1.691,19.161-5.011c9.213-5.133,15.875-13.547,18.759-23.692c0.23-0.81,0.434-1.62,0.611-2.43l75.083-20.8
            c10.844-3.704,25.079-5.039,31.417,9.558C447.978,419.533,430.928,428.96,426.496,431.074z"/>
    </g>
</g>
<g>
    <g>
        <path d="M359.06,131.543c-0.13-0.64-0.32-1.27-0.58-1.88c-0.25-0.6-0.55-1.18-0.92-1.72c-0.36-0.55-0.78-1.06-1.24-1.52
            c-0.46-0.46-0.97-0.88-1.52-1.24c-0.54-0.36-1.12-0.67-1.72-0.92c-0.61-0.25-1.24-0.45-1.87-0.57c-1.29-0.26-2.62-0.26-3.91,0
            c-0.64,0.12-1.27,0.32-1.87,0.57c-0.61,0.25-1.19,0.56-1.73,0.92c-0.55,0.36-1.06,0.78-1.52,1.24c-0.46,0.46-0.88,0.97-1.24,1.52
            c-0.36,0.54-0.67,1.12-0.92,1.72c-0.25,0.61-0.45,1.24-0.57,1.88c-0.13,0.64-0.2,1.3-0.2,1.95c0,0.65,0.07,1.31,0.2,1.95
            c0.12,0.64,0.32,1.27,0.57,1.87c0.25,0.61,0.56,1.19,0.92,1.73c0.36,0.55,0.78,1.06,1.24,1.52c0.46,0.46,0.97,0.88,1.52,1.24
            c0.54,0.36,1.12,0.67,1.73,0.92c0.6,0.25,1.23,0.44,1.87,0.57s1.3,0.2,1.95,0.2c0.65,0,1.31-0.07,1.96-0.2
            c0.63-0.13,1.26-0.32,1.87-0.57c0.6-0.25,1.18-0.56,1.72-0.92c0.55-0.36,1.06-0.78,1.52-1.24c0.46-0.46,0.88-0.97,1.24-1.52
            c0.37-0.54,0.67-1.12,0.92-1.73c0.26-0.6,0.45-1.23,0.58-1.87c0.13-0.64,0.19-1.3,0.19-1.95
            C359.25,132.843,359.19,132.183,359.06,131.543z"/>
    </g>
</g>
<g>
    <g>
        <path d="M502,33.891h-59.457c-5.523,0-10,4.477-10,10v8.634H404.66c-5.523,0-10,4.477-10,10v2.878
            c-16.254-1.419-21.6-4.501-36.527-13.109c-11.48-6.62-28.831-16.625-60.078-30.674c-0.145-0.066-0.291-0.127-0.44-0.185
            c-10.171-4.002-36.828-11.876-65.299,1.027l-40.24,14.408L158.157,2.952c-3.905-3.905-10.237-3.905-14.142,0L32.657,114.309
            c-3.602,3.603-4.293,9.85,0,14.143l190.287,190.287c3.045,3.046,10.175,3.967,14.143,0l101.665-101.664
            c2.643,0.228,5.386,0.351,8.229,0.351c26.126,0,49.236-17.922,62.457-37.456H502c5.523,0,10-4.477,10-10V43.891
            C512,38.368,507.523,33.891,502,33.891z M151.085,24.165l22.792,22.792c-6.775,4.19-14.608,6.432-22.792,6.432
            c-8.185,0-16.017-2.241-22.792-6.432L151.085,24.165z M76.663,144.173L53.871,121.38l22.792-22.792
            c4.19,6.775,6.432,14.608,6.432,22.792C83.095,129.564,80.854,137.397,76.663,144.173z M230.016,297.525l-22.788-22.788
            c13.913-8.586,31.661-8.586,45.575,0L230.016,297.525z M267.211,260.331c-22.098-16.03-52.292-16.03-74.39,0L91.07,158.579
            c7.809-10.74,12.025-23.641,12.025-37.199c0-13.559-4.215-26.459-12.025-37.199l22.817-22.816
            c10.74,7.809,23.64,12.025,37.199,12.025c13.559,0,26.459-4.216,37.199-12.025l21.629,21.629
            c-4.667,0.689-9.218,2.227-13.462,4.592c-7.168,3.994-12.792,9.975-16.294,17.211c-11.28,2.089-21.723,7.55-29.915,15.741
            c-22.225,22.226-22.225,58.389,0.001,80.615c11.112,11.112,25.709,16.669,40.307,16.669c14.597,0,29.195-5.556,40.308-16.669
            c7.23-7.23,12.295-16.116,14.832-25.8l33.764,11.459c-3.801,17.608,0.092,36.132,10.593,50.682L267.211,260.331z M206.413,162.018
            c0.088,0.032,0.176,0.064,0.265,0.094l19.996,6.787c-1.51,6.815-4.927,13.081-9.957,18.112c-14.428,14.426-37.904,14.428-52.33,0
            c-14.428-14.427-14.428-37.902,0-52.33c3.48-3.482,7.587-6.203,12.062-8.048C178.295,141.995,189.356,155.688,206.413,162.018z
             M304.457,223.084c-3.86-6.29-6.044-13.469-6.389-20.796c4.79,3.463,10.644,6.856,17.636,9.549L304.457,223.084z M394.659,165.983
            c-9.478,15.538-27.86,31.441-47.678,31.441c-3.708,0-7.183-0.264-10.432-0.734c-0.013-0.002-0.026-0.004-0.039-0.006
            c-21.596-3.137-33.213-15.411-37.042-20.271c-0.204-0.3-1.073-1.437-1.202-1.626c-1.165-2.082-3.075-3.756-5.511-4.583
            l-79.508-26.985c-12.688-4.762-19.395-15.627-16.321-26.463c0.002-0.007,0.004-0.014,0.006-0.021
            c0.003-0.008,0.005-0.017,0.007-0.025c1.429-4.99,4.711-9.129,9.247-11.656c4.506-2.511,9.715-3.134,14.683-1.757l89.593,28.391
            c5.266,1.671,10.886-1.247,12.554-6.512c1.668-5.265-1.247-10.885-6.512-12.554l-71.255-22.58l-0.622-0.622
            c-0.006-0.006-0.012-0.013-0.019-0.019l-36.89-36.89l31.708-11.354c0.107-0.039,0.239-0.088,0.345-0.131
            c0.027-0.011,0.079-0.031,0.105-0.042c0.136-0.055,0.27-0.113,0.403-0.174c21.436-9.852,41.812-3.955,49.799-0.849
            c30.183,13.581,46.293,22.87,58.063,29.657c16.364,9.437,24.249,13.984,46.518,15.823V165.983z M432.543,159.968H414.66V72.525
            h17.883V159.968z M492,159.968h-39.457V53.891H492V159.968z"/>
    </g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
<g>
</g>
</svg>
</span><div class="wpcc_avacod">'.$codtxt.'</div></div><p class="deliverytime">'.$deliverydaystext.'</p>';
                }

            }

            $data['avai_msg'] = $avai_msg;

            echo json_encode( $data );
            
            exit();
        }

    function WPCC_pincode_change_checkout() {
            if(isset($_REQUEST['pincode']) && $_REQUEST['pincode'] != '') {
                $pincode = sanitize_text_field($_REQUEST['pincode']);
                $expiry = strtotime('+7 day');
                setcookie('wpcc_postcode', $pincode, $expiry , COOKIEPATH, COOKIE_DOMAIN);
                
                global $wpdb;
                $tablename=$wpdb->prefix.'wpcc_postcode';
                $cntSQL = "SELECT * FROM {$tablename} where wpcc_pincode='".$pincode."'";
                $record = $wpdb->get_results($cntSQL, OBJECT);
                $totalrec = count($record);
                
                if(setcookie('wpcc_cod', $record[0]->wpcc_cod, $expiry , COOKIEPATH, COOKIE_DOMAIN)){
              
                $this->WPCC_woo_add_cart_fee();
}
            }
        }

 function WPCC_inactive_order_button_html( $button ) {

            if(get_option('wpcc_checkpincode') == "on") {

                if(isset($_COOKIE['wpcc_postcode'])) {

                    global $wpdb;
                    $tablename=$wpdb->prefix.'wpcc_postcode';
                    $cntSQL = "SELECT * FROM {$tablename} where wpcc_pincode='".sanitize_text_field($_COOKIE['wpcc_postcode'])."'";
                    $record = $wpdb->get_results($cntSQL, OBJECT);
                    $totalrec = count($record);

                    if ($totalrec == 1) {

                         return $button;

                    } else {

                        $button_text = apply_filters( 'woocommerce_order_button_text', __( 'Choose valid zipcode on product page then place order', 'woocommerce' ) );
                        $button = '<a class="button" id="wpcc_porepl">' . $button_text . '</a>';
                         return $button;
                    }

                }
            
            } else {
                return $button;
            }
           
        }


function WPCC_check_pincode_shortcode($atts, $content = null) {

            ob_start();

            $this->WPCC_before_add_to_cart_btn();

            $content = ob_get_clean();

            return $content;
        }
        
   
        
        function WPCC_woo_add_cart_fee() {
         
            global $woocommerce;
            if( get_option('wpcc_enable_shipping_cost', 'on') == 'on' ){
            
                if(isset($_COOKIE['wpcc_postcode'])) {
                    global $wpdb;
                    $tablename=$wpdb->prefix.'wpcc_postcode';
                    $cntSQL = "SELECT * FROM {$tablename} where wpcc_pincode='".sanitize_text_field($_COOKIE['wpcc_postcode'])."'";
                    $record = $wpdb->get_results($cntSQL, OBJECT);
                    //print_r( $record[0]);
                    if($record && $record[0]->wpcc_ship_amount != 0 && !empty($record[0]->wpcc_ship_amount)){
                        $woocommerce->cart->add_fee( __('Shipping Amount', 'woocommerce'), $record[0]->wpcc_ship_amount);
                        
                       
                    }
                    
                }
            }
            if(isset($_COOKIE['wpcc_cod'])){
            $cod_Status=sanitize_text_field($_COOKIE['wpcc_cod']);
             if( $cod_Status == '1' ){
                if(isset($_COOKIE['wpcc_postcode'])) {
                    global $wpdb;
                    $tablename=$wpdb->prefix.'wpcc_postcode';
                    $cntSQL = "SELECT * FROM {$tablename} where wpcc_pincode='".sanitize_text_field($_COOKIE['wpcc_postcode'])."'";
                    $record = $wpdb->get_results($cntSQL, OBJECT);
                    //print_r( $record[0]);
                    if($record[0]->wpcc_cod_amount != 0 && !empty($record[0]->wpcc_cod_amount)){
                         $chosen_payment_id = WC()->session->get('chosen_payment_method');

                       if ( empty( $chosen_payment_id ) ){
                        return;
                       }else{
                           if($chosen_payment_id=='cod'){
                                $cash_on_delivary_text= get_option('wpcc_cash_on_delivery_txt', 'Cash On Delivery');
                        $woocommerce->cart->add_fee( __($cash_on_delivary_text, 'woocommerce'), $record[0]->wpcc_cod_amount);
                           }
                       }
                    }
                    
                }
            }
            }
        }
       
   
        function init() {

            if(get_option('wpcc_enable_checkpcode', 'on') == 'on') {
             
                add_shortcode( 'wpcc_check_pincode', array($this, 'WPCC_check_pincode_shortcode' ));
                
                if(get_option('wpcc_checkpcode_pos', 'after_atc') == 'after_atc') {
                    add_action( 'woocommerce_after_add_to_cart_button', array($this,'WPCC_before_add_to_cart_btn'));
                } elseif (get_option('wpcc_checkpcode_pos', 'after_atc') == 'before_atc') {
                    add_action( 'woocommerce_before_add_to_cart_button', array($this,'WPCC_before_add_to_cart_btn'));
                }
                add_action( 'woocommerce_cart_calculate_fees', array($this,'WPCC_woo_add_cart_fee'));
                add_action( 'wp_ajax_WPCC_check_location', array($this,'WPCC_check_location' ));
                add_action( 'wp_ajax_nopriv_WPCC_check_location', array($this,'WPCC_check_location' ));
                add_action( 'wp_ajax_WPCC_pincode_change_checkout', array($this,'WPCC_pincode_change_checkout' ));
                add_action( 'wp_ajax_nopriv_WPCC_pincode_change_checkout', array($this,'WPCC_pincode_change_checkout' ));
                
                    if(get_option('wpcc_hide_addtocart_sbtn', 'off') == 'on') {
                   // remove addtocart button
            add_filter( 'woocommerce_loop_add_to_cart_link','replace_add_to_cart_with_quickview', 10, 2 );
            function replace_add_to_cart_with_quickview( $button, $product) {

    return '';

}}
                if(get_option('wpcc_disable_addtocart_pbtn', 'off') == 'on') {
                    
                      wc_enqueue_js( "jQuery( function($){
          
       $('.single_add_to_cart_button').prop('disabled', true);
    });");
                }
                 // jQuery - Update checkout on methode payment change
             
               add_action( 'woocommerce_checkout_init', 'payment_methods_refresh_checkout' );
            function payment_methods_refresh_checkout() {
            wc_enqueue_js( "jQuery( function($){
          
        $('form.checkout').on('change', 'input[name=payment_method],#billing_postcode,#shipping_postcode', function(){
            $(document.body).trigger('update_checkout');
        });
    });");
}


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
    WPCC_front::instance();
}