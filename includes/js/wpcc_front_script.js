function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
            var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}


jQuery(document).ready(function() {

    wpcc_postcode = getCookie("wpcc_postcode");
    jQuery("#billing_postcode").val(wpcc_postcode);
    var handlingTime= jQuery("#handling_time").val();
    
    if(wpcc_postcode && wpcc_postcode !==''){
                    jQuery.ajax({
                type: "post",
                dataType: 'json',
                url: wpcc_ajax_postajax.ajaxurl,
                data: { 
                        action:   "WPCC_check_location",
                        postcode: wpcc_postcode,
                        handlingTime:handlingTime
                     },
                success: function(msg) {
                   
                    if(msg.totalrec == 1) {
                        jQuery('.wpcc_checkcode').show();
                        jQuery('.wpcc_cookie_check_div').hide();
                        jQuery('.wpcccheckbtn').show();
                        
                        var date = '';
                        if(msg.showdate == "on") {
                            date = "delivery date : "+msg.deliverydate;
                        }
                        jQuery('.response_pin').html(msg.avai_msg);
                        jQuery('.wpcc_avaicode').html(wpcc_postcode);
					
                         jQuery('.single_add_to_cart_button').prop('disabled', false);
					
                    } else {
                        jQuery('.wpcc_checkcode').show();
                        jQuery('.wpcccheckbtn').show();
                        jQuery('.wpcc_cookie_check_div').hide();
                        jQuery('.wpcc_avaicode').html(wpcc_postcode);
                        jQuery('.response_pin').html('<span class="notavailable">'+wpcc_not_srvcbl_txt.not_serving+'</span>');
					
                        if(msg.disablecartbtn == "on") {
                         jQuery('.single_add_to_cart_button').prop('disabled', true);
						}
                    }
                }
            });
    }

    jQuery("body").on('click', '.wpccbtn', function() {

        var postcode = jQuery('.wpcccheck').val();
        var handlingTime= jQuery("#handling_time").val();
   
        if(postcode !== '') {
            jQuery('.wpcc_empty').css('display', 'none');
            jQuery('.wpccc_maindiv').append('<div class="wpccc_spinner"><img src="'+ wpcc_plugin_url.plugin_url +'/includes/images/loader-3.gif"></div>');
            jQuery('.wpccc_maindiv').addClass('wpccc_loader');
            jQuery.ajax({
                type: "post",
                dataType: 'json',
                url: wpcc_ajax_postajax.ajaxurl,
                data: { 
                        action:   "WPCC_check_location",
                        postcode: postcode,
                        handlingTime:handlingTime
                     },
                success: function(msg) {
                    jQuery(".wpccc_spinner").remove();
                    jQuery('.wpccc_maindiv').removeClass('wpccc_loader');
                    if(msg.totalrec == 1) {
                        jQuery('.wpcc_checkcode').show();
                        jQuery('.wpcc_cookie_check_div').hide();
                         jQuery('.wpcccheckbtn').show();
                        var date = '';
                        if(msg.showdate == "on") {
                            date = "delivery date : "+msg.deliverydate;
                        }
                        jQuery('.response_pin').html(msg.avai_msg);
                        jQuery('.wpcc_avaicode').html(postcode);
					
							jQuery('.single_add_to_cart_button').prop('disabled', false);
				
                    } else {
                        jQuery('.wpcc_checkcode').show();
                          jQuery('.wpcccheckbtn').show();
                        jQuery('.wpcc_cookie_check_div').hide();
                        jQuery('.wpcc_avaicode').html(postcode);
                        jQuery('.response_pin').html('<span class="notavailable">'+wpcc_not_srvcbl_txt.not_serving+'</span>');
				
                       if(msg.disablecartbtn == "on") {
                         jQuery('.single_add_to_cart_button').prop('disabled', true);
						}
                    }
                }
            });
        } else {
            jQuery('.wpcc_empty').css('display', 'block');
        }

    });


    jQuery("body").on('click', '.wpcccheckbtn', function() {
        jQuery('.wpcc_cookie_check_div').css('display', 'flex');
        jQuery('.wpcc_checkcode').hide();
        jQuery(this).hide();
    });



    jQuery("body").on('blur', '#billing_postcode', function() {
        
         if(jQuery('#ship-to-different-address-checkbox').prop('checked')){
        
                var pincode = jQuery('#shipping_postcode').val();
           }else{
         var pincode = jQuery(this).val();
       
    }
        if(pincode !== '') {
            jQuery.ajax({
                type: "POST",
                url: wpcc_ajax_postajax.ajaxurl,
                dataType: 'json',
                data: { 
                        action:"WPCC_pincode_change_checkout",
                        pincode: pincode,
                     },
                success: function(response) {
                    jQuery("body").trigger("update_checkout");
                }
            });
        }
    
    });
      jQuery("body").on('blur', '#shipping_postcode', function() {
        var pincode = jQuery(this).val();

        if(pincode !== '') {
            jQuery.ajax({
                type: "POST",
                url: wpcc_ajax_postajax.ajaxurl,
                dataType: 'json',
                data: { 
                        action:"WPCC_pincode_change_checkout",
                        pincode: pincode,
                     },
                success: function(response) {
                    jQuery("body").trigger("update_checkout");
                }
            });
        }

    });

jQuery("body").on('click', '#ship-to-different-address-checkbox', function() {
   if(jQuery(this).prop('checked')){
   
        var pincode = jQuery('#shipping_postcode').val();
   }else{
   
        var pincode = jQuery('#billing_postcode').val();
   }
        

        if(pincode != '') {
            jQuery.ajax({
                type: "POST",
                url: wpcc_ajax_postajax.ajaxurl,
                dataType: 'json',
                data: { 
                        action:"WPCC_pincode_change_checkout",
                        pincode: pincode,
                     },
                success: function(response) {
                    jQuery("body").trigger("update_checkout");
                }
            });
        }
  

    });
    
    jQuery("body").on('change', 'input[name=payment_method]', function() {
     
        
   if(jQuery('#ship-to-different-address-checkbox').prop('checked')){
   
        var pincode = jQuery('#shipping_postcode').val();
   }else{
   
        var pincode = jQuery('#billing_postcode').val();
   }
        

        if(pincode !== '') {
            jQuery.ajax({
                type: "POST",
                url: wpcc_ajax_postajax.ajaxurl,
                dataType: 'json',
                data: { 
                        action:"WPCC_pincode_change_checkout",
                        pincode: pincode,
                     },
                success: function(response) {
                    jQuery("body").trigger("update_checkout");
                }
            });
        }
  

    });
    
    
    
});
