(function(){
    tinymce.create('tinymce.plugins.sc_for_twitter_bootscrap_sls', {
        createControl : function(id, controlManager) {
            if (id == 'sc_for_twitter_bootscrap_sls_button') {
                // creates the button
                var button = controlManager.createButton('sc_for_twitter_bootscrap_sls_button', {
                    title : 'Shortcode',
                    image : '../wp-content/plugins/respondo-shortcode/imgs/favicon.png',
                    onclick : function() {
                        var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
                        W = W - 50;
                        H = H - 150;
                        tb_show( 'Shortcode For Twitter Bootstrap', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=tb-shortcodes-form-sls' );
                    }
                });
                return button;
            }
            return null;
        }
    });
	
    tinymce.PluginManager.add('sc_for_twitter_bootscrap_sls', tinymce.plugins.sc_for_twitter_bootscrap_sls);
    
    jQuery('#shortcode-submit-sls').click(function() {
        $id = jQuery('#shortcodes-list-select-sls').val();
        
        $shortcode = '';
        $fg = true;
        jQuery('#'+$id + ' .root_datas [required="required"]').each(function() {
            jQuery(this).css('border-color', '#dfdfdf');
            if(jQuery(this).attr("readonly") != "readonly") {
                $tmp = jQuery(this).val().trim();
                if($tmp == '') {
                    jQuery(this).css('border-color', '#ff0000');
                    jQuery(this).focus();
                    $fg = false;
                }
                jQuery(this).val($tmp);
            }
        });
        jQuery('#'+$id + ' .add_items [required="required"]').each(function() {
            jQuery(this).css('border-color', '#dfdfdf');
            if(jQuery(this).attr("readonly") != "readonly") {
                $tmp = jQuery(this).val().trim();
                if($tmp == '') {
                    jQuery(this).css('border-color', '#ff0000');
                    jQuery(this).focus();
                    $fg = false;
                }
                jQuery(this).val($tmp);
            }
        });
        
        $idx_tmp = 0;
        jQuery('#'+$id + ' .root_datas [class*="no-attr"]').each(function() {
            ++$idx_tmp;
        });
        jQuery('#'+$id + ' .root_datas [class*="attr-info"]').each(function() {
            ++$idx_tmp;
        });
        jQuery('#'+$id + ' .sub_data_grp [class*="sub-attr-info"]').each(function() {
            ++$idx_tmp;
        });
        
        jQuery('#'+$id + ' .root_datas [class="all-view-shortcode"]').each(function() {			
			$tmp = jQuery('#plugin_url_ajax_rs').val();
			$url = $tmp + 'get_pagecontent.php';
			jQuery.ajax({
				type : "POST",
				dataType : "html",
				url : $url,
				data : { filename : jQuery(this).val() },
				success: function( response ) {
					if(response == 'error') {
						alert("Error Open");
					} else {
						window.send_to_editor( response );
					}
				}
			});
        });

		jQuery('#'+$id + ' .root_datas [class="flexible-responsive-iframe"]').each(function() {			
			window.send_to_editor( "<p>[rs-responsive-iframe]</p><p>[/rs-responsive-iframe]</p>" );
        });
		
        if($idx_tmp == 0) {
            tb_remove();
        } else {
            if($fg) {
                $shortcode = '';
                $shortcode += '[rs-'+$id;
                $root_content = '';
                jQuery('#'+$id + ' .root_datas [class*="attr-info"]').each(function() {
                    $tmp = jQuery(this).val().trim();
                    if(jQuery(this).attr('name') == 'content') {
                        $root_content = '<p>'+$tmp+'</p>';
                    } else {
                        $shortcode += ' ';
                        $shortcode += jQuery(this).attr('name')+'="'+$tmp+'"';
                    }
                });
                //$shortcode += ']';
                $for_root_shortcode = '';
                jQuery('#'+$id + ' .root_datas [class="sub-attr-info-for-root"]').each(function() {
                    $tmp = jQuery(this).val().trim();

                    $for_root_shortcode += '<p>[rs-'+jQuery(this).attr('subname');
                    if(jQuery(this).attr('name') == 'content') {
                        $for_root_shortcode += ']';
                        $for_root_shortcode += '<p>'+$tmp+'</p>';
                        $for_root_shortcode += '[/rs-'+jQuery(this).attr('subname')+']</p>';
                    } else {
                        $for_root_shortcode += ' ';
                        $for_root_shortcode += jQuery(this).attr('name')+'="'+$tmp+'"';
                        $for_root_shortcode += '/]</p>';
                    }
                });
                $sub_id = jQuery('#'+$id + ' input[name="sub_shortcode"]').val();
                $sub_shortcode = '';
                if($sub_id) {
                    $sub_content = '';
                    jQuery('#'+$id + ' .add_items .sub_data_grp').each(function() {
                        $tmp_test = jQuery('input[name="sub_shortcode"]', this).length;
                        if($tmp_test) 
                            $sub_id = jQuery('input[name="sub_shortcode"]', this).val();

                        $sub_shortcode += '<p>[rs-'+$sub_id;
                    
                        $tmp_sc = '';
                        jQuery('[class*="sub-attr-info"]', this).each(function() {
                            $tmp = jQuery(this).val().trim();
                            if(jQuery(this).attr('name') == 'content') {
                                $sub_content = '<p>'+$tmp+'</p>';
                            } else {
                                $tmp_sc += ' ';
                                $tmp_sc += jQuery(this).attr('name')+'="'+$tmp+'"';
                            }
                        });
                        if($tmp_sc != '') {
                            $sub_shortcode += ' ';
                            $sub_shortcode += $tmp_sc;
                        }
                        if($sub_content) {
                            $sub_shortcode += ']';
                            $sub_shortcode += $sub_content;
                            $sub_shortcode += '[/rs-'+$sub_id;
                            $sub_shortcode += ']</p>';
                        } else {
                            $sub_shortcode += '/]</p>';
                        }
                    });
                }
                if($root_content == '' && $sub_shortcode == '' && $for_root_shortcode == '') {
                    $shortcode += '/]';
                } else {
                    $shortcode += ']';
                    if($sub_id) {
                        $shortcode += $sub_shortcode;
                    } else {
                        $shortcode += $for_root_shortcode;
                        $shortcode += $root_content;
                    }
                    $shortcode += '[/rs-'+$id;
                    $shortcode += ']';
                }
            
                $wrap = jQuery('#'+$id + ' select[name="wrap"]').val();
                if($wrap) {
                    if($id == 'button' || $id == 'image') {
                        if($wrap == 'yes') {
                        //$shortcode += '<p></p>';
                        }
                    } else {
                    //$shortcode += '<p></p>';
                    }
                } else {
                //$shortcode += '<p></p>';
                }
                window.send_to_editor($shortcode);
            //tinyMCE.activeEditor.execCommand('mceInsertContent', 0, $shortcode);
            //tb_remove();
            }
        }
    });
	
    jQuery('#shortcode-cancel-sls').click(function() {
        tb_remove();
    });
	
	jQuery('select[name=lightbox]').change(function(){
		$index = jQuery(this).attr('index');
		if( jQuery(this).val() == 'yes' ) {
			jQuery("#light_bg_color" + $index).addClass("attr-info");
			jQuery("#light_bg_color" + $index).parent().parent().css("display", "inherit");
			jQuery("#light_bg_color" + $index).parent().parent().prev().css("display", "inherit");
			
			jQuery("#link_val" + $index).removeClass("attr-info");
			jQuery("#link_val" + $index).parent().parent().css("display", "none");
			jQuery("#link_val" + $index).parent().parent().prev().css("display", "none");
			
			jQuery("#open_method" + $index).removeClass("attr-info");
			jQuery("#open_method" + $index).parent().parent().css("display", "none");
			jQuery("#open_method" + $index).parent().parent().prev().css("display", "none");
		}else{
			jQuery("#light_bg_color" + $index).removeClass("attr-info");
			jQuery("#light_bg_color" + $index).parent().parent().css("display", "none");
			jQuery("#light_bg_color" + $index).parent().parent().prev().css("display", "none");
			
			jQuery("#link_val" + $index).addClass("attr-info");
			jQuery("#link_val" + $index).parent().parent().css("display", "inherit");
			jQuery("#link_val" + $index).parent().parent().prev().css("display", "inherit");
			
			jQuery("#open_method" + $index).addClass("attr-info");
			jQuery("#open_method" + $index).parent().parent().css("display", "inherit");
			jQuery("#open_method" + $index).parent().parent().prev().css("display", "inherit");
		}
	});
	
	jQuery('select[id^=open_method]').parent().parent().prev().css("display", "none");
	jQuery('select[id^=open_method]').parent().parent().css("display", "none");
	
	jQuery('input[id^=link_val]').parent().parent().prev().css("display", "none");
	jQuery('input[id^=link_val]').parent().parent().css("display", "none");
})()