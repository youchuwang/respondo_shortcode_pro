function insert_item_rs($id) {
    $body_st = jQuery('#'+$id+' .add_item_tmp').html();
    jQuery('#'+$id+' .add_items').append($body_st);

    jQuery('#'+$id + ' .add_items .sub_data_grp div[class="ctrl"] input[name="label"]').each(function() {
        jQuery(this).focus();
    });
    jQuery('#'+$id + ' .add_items .sub_data_grp div[class="ctrl"] input[name="title"]').each(function() {
        jQuery(this).focus();
    });

    reindexing_rs($id);
}

function del_item_rs(obj, $id) {
    jQuery(obj).parent().remove();
    reindexing_rs($id);
}

function reindexing_rs($id) {
    $idx = 1;
    jQuery('#'+$id + ' .add_items .sub_data_grp').each(function() {
        jQuery('span[class="number"]', this).each(function() {
            jQuery(this).text($idx);
        });
        $idx++;
    });
}

function divider_item_rs(obj) {
    $pobj = jQuery(obj).parent().parent().parent();
    if(jQuery(obj).attr('checked')) {
        jQuery(obj).attr('value', 'divider');
        jQuery('input', $pobj).each(function() {
            if(jQuery(this).attr('name') == 'divider') {
                jQuery(this).addClass('sub-attr-info');
            } else {
                jQuery(this).removeClass('sub-attr-info');
                jQuery(this).addClass('display_none');
            }
        });
        jQuery('input[name=label]', $pobj).each(function() {
            jQuery(this).removeAttr('required');
        });
        jQuery('.title', $pobj).each(function() {
            jQuery(this).addClass('display_none');
        });
        jQuery('.descript', $pobj).each(function() {
            jQuery(this).addClass('display_none');
        });
    } else {
        jQuery(obj).removeAttr('value');
        jQuery('input', $pobj).each(function() {
            if(jQuery(this).attr('name') == 'divider') {
                jQuery(this).removeClass('sub-attr-info');
            } else {
                jQuery(this).addClass('sub-attr-info');
                jQuery(this).removeClass('display_none');
            }
        });
        jQuery('input[name=label]', $pobj).each(function() {
            jQuery(this).attr('required', 'required');
            jQuery(this).removeClass('display_none');
        });
        jQuery('.title', $pobj).each(function() {
            jQuery(this).removeClass('display_none');
        });
        jQuery('.descript', $pobj).each(function() {
            jQuery(this).removeClass('display_none');
        });
    }
}

function select_default_tab_accordion_stacked_tabs_container_rs($this, $p_nm) {
    jQuery('#'+$p_nm + ' input[name="default_tab"]').each(function() {
        jQuery(this).removeClass('sub-attr-info');
        jQuery(this).attr("value", "");
    });
    jQuery($this).addClass('sub-attr-info');
    jQuery($this).attr("value", "default");
}

var $columns_num = 0;
var $after_fix = '';
function select_column_number_rs($this, $after_fix_txt) {
    $after_fix = $after_fix_txt;
    $columns_num = jQuery($this).val();
    $input_str = '<div class="clear"></div><input type="button" value="%%number%%" style="width: %%width%%px; text-align: left; padding-left: 5px" onClick="insert_columns_rs(this)" class="btn_column-%%number_cls%%">';
    $attach_str = '';
    $t = 0;
    $width = '90';

    for (var $i = 0; $i < jQuery($this).val(); $i++) {
        ++$t;
        $tmp = '';
        $tmp = $input_str.replace('%%number%%',  get_name_columns_rs($t+'/'+jQuery($this).val()));
        $tmp = $tmp.replace('%%number_cls%%', $t);
        $tmp_v = parseInt($width)+parseInt($t)*20;
        $tmp = $tmp.replace('%%width%%', $tmp_v);
        $attach_str += $tmp;
    }

    jQuery(jQuery($this).next()).html($attach_str);
    jQuery(jQuery($this).next().next()).html('');
}
function insert_columns_rs(obj) {
    $str = jQuery(obj).attr('class');    
    $ary = $str.split("-");

    $columns_num -= $ary[1];
    $test_tmp = $ary[1];

    $str = obj.value;
    $ary = $str.split('/');
    $span_num = 12 * $ary[0]/$ary[1];
    
    //$tmp_str = get_name_columns_rs($ary[0]/$ary[1]);
    
    $attach_str = '<div class="sub_data_grp"><input type="hidden" name="sub_shortcode" value="'+obj.value+'"><textarea name="content" rows="4" cols="40" class="sub-attr-info" style="float: left" >Column '+obj.value+'</textarea><div class="del" onClick="del_columns_rs(this, '+$test_tmp+')"></div><div class="h_10"></div></div>';
    jQuery(jQuery(obj).parent().next()).append($attach_str);
    reindexing_columns_rs(jQuery(obj).parent());
}

function del_columns_rs(obj, num) {
    $column_v_obj = jQuery(obj).parent().parent().prev();
    jQuery(obj).parent().remove();
    $columns_num += num;
    reindexing_columns_rs($column_v_obj);
}

function reindexing_columns_rs($column_v_obj) {
    $add_items_obj = jQuery($column_v_obj).next();

    $tmp_len = jQuery('textarea[name=content]', $add_items_obj).length;
    jQuery('input[class^="btn_column"]', $column_v_obj).each(function () {
        if($columns_num > 0) {
            $str = jQuery(this).attr('class');
            $ary_tmp = $str.split(" ");

            if($ary_tmp.length == 1) {
                $ary = $str.split('-');
                $tmp_num = $ary[1];
            } else {
                $str = $ary_tmp[0];
                $ary = $str.split('-');
                $tmp_num = $ary[1];
            }
                
            if($tmp_num > $columns_num) {
                jQuery(this).attr('disabled', 'disabled');
                jQuery(this).addClass('col_disabled');
            } else {
                jQuery(this).removeAttr('disabled');
                jQuery(this).removeClass('col_disabled');
            }
        } else {
            jQuery(this).attr('disabled', 'disabled');
            jQuery(this).addClass('col_disabled');
        }
    });
}

function get_name_columns_rs($str) {
    $ret_str = '';
    switch($str) {
        case '1/12':
            $ret_str = 'one_twelth'+$after_fix;
            break;
        case '2/12':
            $ret_str = 'one_sixth'+$after_fix;
            break;
        case '3/12':
            $ret_str = 'three_twelths'+$after_fix;
            break;
        case '4/12':
            $ret_str = 'one_third'+$after_fix;
            break;
        case '5/12':
            $ret_str = 'five_twelths'+$after_fix;
            break;
        case '6/12':
            $ret_str = 'one_half'+$after_fix;
            break;
        case '7/12':
            $ret_str = 'seven_twelths'+$after_fix;
            break;
        case '8/12':
            $ret_str = 'two_thirds'+$after_fix;
            break;
        case '9/12':
            $ret_str = 'nine_twelths'+$after_fix;
            break;
        case '10/12':
            $ret_str = 'five_sixths'+$after_fix;
            break;
        case '11/12':
            $ret_str = 'eleven_twelths'+$after_fix;
            break;
        case '12/12':
            $ret_str = 'full_width'+$after_fix;
            break;
        case '1/2':
            $ret_str = 'one_half'+$after_fix;
            break;
        case '2/2':
            $ret_str = 'full_width'+$after_fix;
            break;
        case '1/3':
            $ret_str = 'one_third'+$after_fix;
            break;
        case '2/3':
            $ret_str = 'two_thirds'+$after_fix;
            break;
        case '3/3':
            $ret_str = 'full_width'+$after_fix;
            break;
        case '1/4':
            $ret_str = 'one_quarter'+$after_fix;
            break;
        case '2/4':
            $ret_str = 'one_half'+$after_fix;
            break;
        case '3/4':
            $ret_str = 'three_quarters'+$after_fix;
            break;
        case '4/4':
            $ret_str = 'full_width'+$after_fix;
            break;
        case '1/6':
            $ret_str = 'one_sixth'+$after_fix;
            break;
        case '2/6':
            $ret_str = 'one_third'+$after_fix;
            break;
        case '3/6':
            $ret_str = 'one_half'+$after_fix;
            break;
        case '4/6':
            $ret_str = 'two_thirds'+$after_fix;
            break;
        case '5/6':
            $ret_str = 'five_sixths'+$after_fix;
            break;
        case '6/6':
            $ret_str = 'full_width'+$after_fix;
            break;
    };
    return $ret_str;
}

jQuery(document).ready(function () {
    category_rs();
    function category_rs() {
        $tmp = jQuery('#plugin_url_ajax_rs').val();
        $url = $tmp+'get_category.php';
        $str = '';
        jQuery.ajax({
            type : "POST",
            dataType : "html",
            url : $url,
            data : $str,
            success: function(response) {
                if(response == 'error') {
                    jQuery('.blog_category').parent().parent().parent().html('There is no category');
                } else {
                    jQuery('.blog_category').html(response);
                }
            }
        });
    }
    
    portfolio_rs();
    function portfolio_rs() {
        $tmp = jQuery('#plugin_url_ajax_rs').val();
        $url = $tmp+'get_category.php';
        $str = {
            post_type:'portfolio-item',
            taxonomy:'category-portfolio'
        };
        jQuery.ajax({
            type : "POST",
            dataType : "html",
            url : $url,
            data : $str,
            success: function(response) {
                if(response == 'error')
                    jQuery('#portfolio .root_datas').html('There is no category');
                else 
                    jQuery('#portfolio .portfolio_category').html(response);
            }
        });
    }

    get_pages_rs();
    function get_pages_rs() {
        $tmp = jQuery('#plugin_url_ajax_rs').val();
        $url = $tmp+'get_pages.php';
        $str = '';
        jQuery.ajax({
            type : "POST",
            dataType : "html",
            url : $url,
            data : $str,
            success: function(response) {
                if(response == 'error') {
                    jQuery('.page_list').parent().parent().parent().html('There is no pages');
                } else {
                    jQuery('.page_list').html(response);
                }
            }
        });
    }
    /*
    get_events_cat_rs();
    function get_events_cat_rs() {
        $tmp = jQuery('#plugin_url_ajax_rs').val();
        $url = $tmp+'get_category.php';
        $str = {
            post_type:'events',
            taxonomy:'category-event'
        };
        jQuery.ajax({
            type : "POST",
            dataType : "html",
            url : $url,
            data : $str,
            success: function(response) {
                if(response == 'error')
                    jQuery('#events .root_datas').html('There is no category');
                else 
                    jQuery('#events .category').html(response);
            }
        });
    }
    */
    
    // color picker
    var f = jQuery.farbtastic('#shortcodes-form-sls #color-picker-int');

    jQuery('#shortcodes-form-sls .color_picker').each(function () {
        f.linkTo(this);
    });

    jQuery('#shortcodes-form-sls .color_picker').live('click', function(){
        jQuery('#shortcodes-form-sls #color-picker-int').css("display", "inline");
        f.linkTo(this);
        jQuery('#shortcodes-form-sls #color-picker-int').insertAfter(this);
    });

    jQuery('#shortcodes-list-select-sls').change(function(){
        jQuery('.shortcode_ctrl').css('display', 'none');
        jQuery('#'+this.value).css('display', 'inline');
        if(this.value)
            jQuery('#shortcode-submit-sls').css('display', 'inline');
        else
            jQuery('#shortcode-submit-sls').css('display', 'none');
        
        $idx = 1;
        jQuery('#'+this.value + ' .add_items .sub_data_grp').each(function() {
            jQuery('span[class="number"]', this).each(function() {
                jQuery(this).text($idx);
            });
            $idx++;
        });
    });
    
    $rs_root_obj = jQuery("#shortcodes-form-sls");
    $rs_root_nm = "#shortcodes-form-sls";

    jQuery('#portfolio select[name=number_of_columns]', $rs_root_obj).change(function() {
        if( jQuery(this).val() == 'full' ) {
            jQuery("#portfolio select[name=pos_f_img] option").each(function() {
                if(jQuery(this).val() == "top"){
                    jQuery(this).attr("selected", "selected");
                } else {
                    jQuery(this).removeAttr("selected");
                }
            });
            jQuery('#portfolio select[name=pos_f_img]', $rs_root_obj).attr('disabled', 'disabled');
            jQuery('#portfolio input[name=number_of_display_portfolio]').val('1');
        } else {
            jQuery('#portfolio select[name=pos_f_img]', $rs_root_obj).removeAttr('disabled', 'disabled');
            jQuery('#portfolio input[name=number_of_display_portfolio]').val(jQuery(this).val());
        }
    });

    jQuery('#insert_icon ul.the-icons li').click(function() {
        jQuery('i', this).each(function() {
            jQuery('#insert_icon input[name=option]').val(jQuery(this).attr('class'));
        });
        jQuery('#insert_icon .preview_icon').html('<i class="'+jQuery('#insert_icon input[name=option]').val()+'"></i>'+jQuery('#insert_icon input[name=option]').val());
    });

    jQuery('#list_icon ul.the-icons li').click(function() {
        jQuery('i', this).each(function() {
            jQuery('#list_icon input[name=option]').val(jQuery(this).attr('class'));
        });
        jQuery('#list_icon .preview_icon').html('<i class="'+jQuery('#list_icon input[name=option]').val()+'"></i>'+jQuery('#list_icon input[name=option]').val());
    });
    
    jQuery('#services_group .icon_list_inter ul.the-icons li').live('click', function() {
        $obj = jQuery(this).parent().parent().parent().parent().parent();
        $class = jQuery('i', this).attr('class');
        jQuery('input[name=icon_nm]', $obj).val($class);
        jQuery('.preview_icon', $obj).html('<i class="'+$class+'"></i>'+$class);
    });
    
    jQuery('#services_group select[name=option]').live('change', function() {
        $title_obj = jQuery(this).parent().parent().next();
        $ctrl_obj = jQuery(this).parent().parent().next().next();
        $size_obj = jQuery(this).parent().parent().next().next().next().next().next();
        
        $color_obj = jQuery(this).parent().parent().next().next().next().next().next().next().next();
        $color_title_obj = jQuery(this).parent().parent().next().next().next().next().next().next();
        
        if(jQuery(this).val() == 'icon') {
            jQuery('input[name=icon_color]', $color_obj).removeClass('display_none');
            jQuery('input[name=icon_color]', $color_obj).addClass('sub-attr-info');
            jQuery($color_title_obj).removeClass('display_none');
            
            $num = jQuery('.number', $title_obj).html();
            jQuery($title_obj).html('Icon <span class="number">'+$num+'</span>');

            jQuery('.icon_list_inter', $ctrl_obj).removeClass('display_none');
            jQuery('.image_url_inter', $ctrl_obj).addClass('display_none');
            jQuery('input[name=img_url]', $ctrl_obj).removeClass('sub-attr-info');
            jQuery('input[name=icon_nm]', $ctrl_obj).addClass('sub-attr-info');
            
            jQuery('.icon_size', $size_obj).removeClass('display_none');
            jQuery('.image_size', $size_obj).addClass('display_none');
            jQuery('select[name=size]', $size_obj).removeClass('sub-attr-info');
            jQuery('input[name=size]', $size_obj).addClass('sub-attr-info');
        }
        if(jQuery(this).val() == 'image') {
            jQuery('input[name=icon_color]', $color_obj).addClass('display_none');
            jQuery('input[name=icon_color]', $color_obj).removeClass('sub-attr-info');
            jQuery($color_title_obj).addClass('display_none');
            
            jQuery('#color-picker-int').css('display', 'none');

            $num = jQuery('.number', $title_obj).html();
            jQuery($title_obj).html('Image URL <span class="number">'+$num+'</span>');
            
            jQuery('.icon_list_inter', $ctrl_obj).addClass('display_none');
            jQuery('.image_url_inter', $ctrl_obj).removeClass('display_none');
            jQuery('input[name=img_url]', $ctrl_obj).addClass('sub-attr-info');
            jQuery('input[name=icon_nm]', $ctrl_obj).removeClass('sub-attr-info');
            
            jQuery('.icon_size', $size_obj).addClass('display_none');
            jQuery('.image_size', $size_obj).removeClass('display_none');
            jQuery('select[name=size]', $size_obj).addClass('sub-attr-info');
            jQuery('input[name=size]', $size_obj).removeClass('sub-attr-info');
        }
    });

    jQuery('#blog_posts select[name=number_of_columns]').change(function() {
        $val = jQuery(this).val();
        if($val == 'full') {
            jQuery("#blog_posts select[name=pos_f_img] option").each(function() {
                if(jQuery(this).val() == "bottom"){
                    jQuery(this).attr("selected", "selected");
                } else {
                    jQuery(this).removeAttr("selected");
                }
            });
            jQuery('#blog_posts select[name=pos_f_img]', $rs_root_obj).attr('disabled', 'disabled');
            jQuery('#blog_posts input[name=number_of_display_blog]').val('1');
        } else {
            jQuery('#blog_posts select[name=pos_f_img]', $rs_root_obj).removeAttr('disabled', 'disabled');
            jQuery('#blog_posts input[name=number_of_display_blog]').val($val);
        }
    });

    jQuery('#divider select[name=type]').change(function() {
        $val = jQuery(this).val();
        $style = "border-style:"+$val;
        jQuery('#divider .divider_sample_style').attr('style', $style);
        $width = 1;
        switch ($val) {
            case 'solid':
                $width = 1;
                break;
            case 'dotted':
                $width = 3;
                break;
            case 'dashed':
                $width = 2;
                break;
            case 'double':
                $width = 3;
                break;
            case 'groove':
                $width = 3;
                break;
            case 'ridge':
                $width = 3;
                break;
            case 'inset':
                $width = 2;
                break;
            case 'outset':
                $width = 2;
                break;
        }
        jQuery('#divider input[name=brd_width]').val($width);
    });

    jQuery('#basic_tabs_container input[name=tab_bg_color]').addClass('display_none');
    jQuery('#basic_tabs_container input[name=tab_bg_color]').parent().parent().prev().addClass('display_none');
    jQuery('#basic_tabs_container select[name=style]').change(function() {
        $val = jQuery(this).val();
        if($val == 'straight') {
            jQuery('#basic_tabs_container input[name=tab_bg_color]').addClass('attr-info');
            jQuery('#basic_tabs_container input[name=tab_bg_color]').removeClass('display_none');
            jQuery('#basic_tabs_container input[name=tab_bg_color]').parent().parent().prev().removeClass('display_none');
        } else {
            jQuery('#basic_tabs_container input[name=tab_bg_color]').removeClass('attr-info');
            jQuery('#basic_tabs_container input[name=tab_bg_color]').addClass('display_none');
            jQuery('#basic_tabs_container input[name=tab_bg_color]').parent().parent().prev().addClass('display_none');
        }
    });

    jQuery('#columns select[name=column]').change(function() {
        jQuery('#column_in_column select[name=column]').val('');
        jQuery('#column_in_column .column_v').html('');
        jQuery('#column_in_column .add_items').html('');
        select_column_number_rs(this, '');
    });
    jQuery('#column_in_column select[name=column]').change(function() {
        jQuery('#columns select[name=column]').val('');
        jQuery('#columns .column_v').html('');
        jQuery('#columns .add_items').html('');
        select_column_number_rs(this, '_cic');
    });
    /*
    jQuery('#split_button_group table select[name=flag]').change(function(){
        if(jQuery(this).val() == '0') {
            jQuery('#split_button_group table input[name=label]').attr('readonly', 'readonly');
            jQuery('#split_button_group table input[name=link]').attr('readonly', 'readonly');
        } else {
            jQuery('#split_button_group table input[name=label]').removeAttr('readonly');
            jQuery('#split_button_group table input[name=link]').removeAttr('readonly');
        }
    });
*/  jQuery('#button select[name=full_width]').change(function(){
        if(jQuery(this).val() == 'yes') {
            //jQuery('#button select[name=position]').attr("disabled", "disabled");
            jQuery('#button select[name=position]').removeClass('attr-info');
            jQuery('#button select[name=position]').addClass('display_none');
            jQuery('#button select[name=position]').parent().parent().prev().addClass('display_none');

            //jQuery('#button select[name=wrap]').attr("disabled", "disabled");
            jQuery('#button select[name=wrap]').removeClass('attr-info');
            jQuery('#button select[name=wrap]').addClass('display_none');
            jQuery('#button select[name=wrap]').parent().parent().prev().addClass('display_none');
        } else {
            //jQuery('#button select[name=position]').removeAttr('disabled');
            jQuery('#button select[name=position]').addClass('attr-info');
            jQuery('#button select[name=position]').removeClass('display_none');
            jQuery('#button select[name=position]').parent().parent().prev().removeClass('display_none');
            
            if(jQuery('#button select[name=position]').val() != 'center') {
                //jQuery('#button select[name=wrap]').removeAttr('disabled');
                jQuery('#button select[name=wrap]').addClass('attr-info');
                jQuery('#button select[name=wrap]').removeClass('display_none');
                jQuery('#button select[name=wrap]').parent().parent().prev().removeClass('display_none');
            }
        }
    });
    
    jQuery('#box_content input[name=out_bkg_color]').addClass('display_none');
    jQuery('#box_content input[name=out_bkg_color]').parent().parent().prev().addClass('display_none');
    jQuery('#box_content input[name=out_brd_color]').addClass('display_none');
    jQuery('#box_content input[name=out_brd_color]').parent().parent().prev().addClass('display_none');
    jQuery('#box_content input[name=width_btw_brd]').addClass('display_none');
    jQuery('#box_content input[name=width_btw_brd]').parent().parent().prev().addClass('display_none');
    jQuery('.descript', jQuery('#box_content input[name=width_btw_brd]').parent().parent()).addClass('display_none');
    jQuery('#box_content select[name=style]').change(function(){
        if(jQuery(this).val() == 'basic_block') {
            jQuery('#box_content input[name=bkg_color]').val('#f5f5f5');
            jQuery('#box_content input[name=brd_color]').val('#ccc');
            jQuery('#box_content input[name=txt_color]').val('#333333');
        }
        if(jQuery(this).val() == 'lined_paper') {
            jQuery('#box_content input[name=bkg_color]').val('#fff');
            jQuery('#box_content input[name=brd_color]').val('#d2d2d2');
            jQuery('#box_content input[name=txt_color]').val('#444');
        }
        if(jQuery(this).val() == 'box_in_box') {
            jQuery('#box_content input[name=bkg_color]').val('#fff');
            jQuery('#box_content input[name=brd_color]').val('#d2d2d2');
            jQuery('#box_content input[name=txt_color]').val('#444');
            jQuery('#box_content input[name=out_bkg_color]').val('#f5f5f5');
            jQuery('#box_content input[name=out_brd_color]').val('#ccc');
        }
        jQuery('.color_picker').each(function () {
            f.linkTo(this);
        });
        if(jQuery(this).val() == 'box_in_box') {
            jQuery('#box_content input[name=out_bkg_color]').addClass('attr-info');
            jQuery('#box_content input[name=out_bkg_color]').removeClass('display_none');
            jQuery('#box_content input[name=out_bkg_color]').parent().parent().prev().removeClass('display_none');
            
            jQuery('#box_content input[name=out_brd_color]').addClass('attr-info');
            jQuery('#box_content input[name=out_brd_color]').removeClass('display_none');
            jQuery('#box_content input[name=out_brd_color]').parent().parent().prev().removeClass('display_none');

            jQuery('#box_content input[name=width_btw_brd]').addClass('attr-info');
            jQuery('#box_content input[name=width_btw_brd]').removeClass('display_none');
            jQuery('#box_content input[name=width_btw_brd]').parent().parent().prev().removeClass('display_none');

            jQuery('.descript', jQuery('#box_content input[name=width_btw_brd]').parent().parent()).removeClass('display_none');
        } else {
            jQuery('#box_content input[name=out_bkg_color]').removeClass('attr-info');
            jQuery('#box_content input[name=out_bkg_color]').addClass('display_none');
            jQuery('#box_content input[name=out_bkg_color]').parent().parent().prev().addClass('display_none');

            jQuery('#box_content input[name=out_brd_color]').removeClass('attr-info');
            jQuery('#box_content input[name=out_brd_color]').addClass('display_none');
            jQuery('#box_content input[name=out_brd_color]').parent().parent().prev().addClass('display_none');

            jQuery('#box_content input[name=width_btw_brd]').removeClass('attr-info');
            jQuery('#box_content input[name=width_btw_brd]').addClass('display_none');
            jQuery('#box_content input[name=width_btw_brd]').parent().parent().prev().addClass('display_none');
            
            jQuery('.descript', jQuery('#box_content input[name=width_btw_brd]').parent().parent()).addClass('display_none');
        }
    });
    
    jQuery('#button select[name=position]').change(function(){
        if(jQuery(this).val() == 'center') {
            //jQuery('#button select[name=wrap]').attr("disabled", "disabled");
            jQuery('#button select[name=wrap]').removeClass('attr-info');
            jQuery('#button select[name=wrap]').addClass('display_none');
            jQuery('#button select[name=wrap]').parent().parent().prev().addClass('display_none');
        } else {
            //jQuery('#button select[name=wrap]').removeAttr('disabled');
            jQuery('#button select[name=wrap]').addClass('attr-info');
            jQuery('#button select[name=wrap]').removeClass('display_none');
            jQuery('#button select[name=wrap]').parent().parent().prev().removeClass('display_none');
        }
    });

    jQuery('#button select[name=custom_type]').change(function() {
        if(jQuery(this).val() == '') {
            jQuery(this).removeClass('attr-info');
        } else {
            jQuery(this).addClass('attr-info');
        }        


        if(jQuery(this).val() != '') {
            //jQuery('#button select[name=type]').attr("disabled", "disabled");
            jQuery('#button select[name=type]').removeClass('attr-info');
            jQuery('#button select[name=type]').addClass('display_none');
            jQuery('#button select[name=type]').parent().parent().prev().addClass('display_none');
            jQuery('#button input[name=btn_txt_color]').removeClass('attr-info');
            jQuery('#button input[name=btn_bkg_color]').removeClass('attr-info');
            jQuery('#button input[name=btn_txt_color]').removeClass('display_none');
            jQuery('#button input[name=btn_bkg_color]').removeClass('display_none');
            jQuery('#button input[name=btn_txt_color]').addClass('display_block');
            jQuery('#button input[name=btn_bkg_color]').addClass('display_block');
            jQuery('#button input[name=btn_txt_color]').parent().parent().prev().addClass('display_block');
            jQuery('#button input[name=btn_bkg_color]').parent().parent().prev().addClass('display_block');
            
            $button_style = new Array();
	        $button_style['custom'] = "display:none !important;";
            $button_style['alpha'] = "background-color: hsl(193, 32%, 49%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b8d3da', endColorstr='#5493a4'); background-image: -khtml-gradient(linear, left top, left bottom, from(#b8d3da), to(#5493a4)); background-image: -moz-linear-gradient(top, #b8d3da, #5493a4); background-image: -ms-linear-gradient(top, #b8d3da, #5493a4); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #b8d3da), color-stop(100%, #5493a4)); background-image: -webkit-linear-gradient(top, #b8d3da, #5493a4); background-image: -o-linear-gradient(top, #b8d3da, #5493a4); background-image: linear-gradient(#b8d3da, #5493a4); border-color: #5493a4 #5493a4 hsl(193, 32%, 41.5%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.49); -webkit-font-smoothing: antialiased;";
            $button_style['foxtrot'] = "background-color: hsl(0, 69%, 22%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b42121', endColorstr='#5e1111'); background-image: -khtml-gradient(linear, left top, left bottom, from(#b42121), to(#5e1111)); background-image: -moz-linear-gradient(top, #b42121, #5e1111); background-image: -ms-linear-gradient(top, #b42121, #5e1111); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #b42121), color-stop(100%, #5e1111)); background-image: -webkit-linear-gradient(top, #b42121, #5e1111); background-image: -o-linear-gradient(top, #b42121, #5e1111); background-image: linear-gradient(#b42121, #5e1111); border-color: #5e1111 #5e1111 hsl(0, 69%, 17%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33); -webkit-font-smoothing: antialiased;";
            $button_style['kilo'] = "background-color: hsl(0, 0%, 79%);background-repeat: repeat-x;background-image: -khtml-gradient(linear, left top, left bottom, from(hsl(0, 0%, 121%)), to(hsl(0, 0%, 79%)));background-image: -moz-linear-gradient(top, hsl(0, 0%, 121%), hsl(0, 0%, 79%));background-image: -ms-linear-gradient(top, hsl(0, 0%, 121%), hsl(0, 0%, 79%));background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, hsl(0, 0%, 121%)), color-stop(100%, hsl(0, 0%, 79%)));background-image: -webkit-linear-gradient(top, hsl(0, 0%, 121%), hsl(0, 0%, 79%));background-image: -o-linear-gradient(top, hsl(0, 0%, 121%), hsl(0, 0%, 79%));background-image: linear-gradient(hsl(0, 0%, 121%), hsl(0, 0%, 79%));border-color: hsl(0, 0%, 79%) hsl(0, 0%, 79%) hsl(0, 0%, 68.5%);color: #333;text-shadow: 0 1px 1px rgba(255, 255, 255, 0.69);-webkit-font-smoothing: antialiased;";
            $button_style['bravo'] = "background-color: hsl(36, 100%, 40%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffad32', endColorstr='#cc7a00'); background-image: -khtml-gradient(linear, left top, left bottom, from(#ffad32), to(#cc7a00)); background-image: -moz-linear-gradient(top, #ffad32, #cc7a00); background-image: -ms-linear-gradient(top, #ffad32, #cc7a00); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffad32), color-stop(100%, #cc7a00)); background-image: -webkit-linear-gradient(top, #ffad32, #cc7a00); background-image: -o-linear-gradient(top, #ffad32, #cc7a00); background-image: linear-gradient(#ffad32, #cc7a00); border-color: #cc7a00 #cc7a00 hsl(36, 100%, 35%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.33); -webkit-font-smoothing: antialiased;";
            $button_style['golf'] = "background-color: hsl(195, 79%, 43%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#56c5eb', endColorstr='#1798c4'); background-image: -khtml-gradient(linear, left top, left bottom, from(#56c5eb), to(#1798c4)); background-image: -moz-linear-gradient(top, #56c5eb, #1798c4); background-image: -ms-linear-gradient(top, #56c5eb, #1798c4); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #56c5eb), color-stop(100%, #1798c4)); background-image: -webkit-linear-gradient(top, #56c5eb, #1798c4); background-image: -o-linear-gradient(top, #56c5eb, #1798c4); background-image: linear-gradient(#56c5eb, #1798c4); border-color: #1798c4 #1798c4 hsl(195, 79%, 38%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.33); -webkit-font-smoothing: antialiased;";
            $button_style['lima'] = "background-color: hsl(145, 62%, 68%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#cdf3dd', endColorstr='#7adfa4'); background-image: -khtml-gradient(linear, left top, left bottom, from(#cdf3dd), to(#7adfa4)); background-image: -moz-linear-gradient(top, #cdf3dd, #7adfa4); background-image: -ms-linear-gradient(top, #cdf3dd, #7adfa4); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #cdf3dd), color-stop(100%, #7adfa4)); background-image: -webkit-linear-gradient(top, #cdf3dd, #7adfa4); background-image: -o-linear-gradient(top, #cdf3dd, #7adfa4); background-image: linear-gradient(#cdf3dd, #7adfa4); border-color: #7adfa4 #7adfa4 hsl(145, 62%, 63%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.33); -webkit-font-smoothing: antialiased;";
            $button_style['charlie'] = "background-color: hsl(86, 79%, 44%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#daf6b5', endColorstr='#7cc817'); background-image: -khtml-gradient(linear, left top, left bottom, from(#daf6b5), to(#7cc817)); background-image: -moz-linear-gradient(top, #daf6b5, #7cc817); background-image: -ms-linear-gradient(top, #daf6b5, #7cc817); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #daf6b5), color-stop(100%, #7cc817)); background-image: -webkit-linear-gradient(top, #daf6b5, #7cc817); background-image: -o-linear-gradient(top, #daf6b5, #7cc817); background-image: linear-gradient(#daf6b5, #7cc817); border-color: #7cc817 #7cc817 hsl(86, 79%, 34%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.66); -webkit-font-smoothing: antialiased;";
            $button_style['hotel'] = "background-color: hsl(0, 0%, 16%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#5b5b5b', endColorstr='#282828'); background-image: -khtml-gradient(linear, left top, left bottom, from(#5b5b5b), to(#282828)); background-image: -moz-linear-gradient(top, #5b5b5b, #282828); background-image: -ms-linear-gradient(top, #5b5b5b, #282828); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #5b5b5b), color-stop(100%, #282828)); background-image: -webkit-linear-gradient(top, #5b5b5b, #282828); background-image: -o-linear-gradient(top, #5b5b5b, #282828); background-image: linear-gradient(#5b5b5b, #282828); border-color: #282828 #282828 hsl(0, 0%, 11%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33); -webkit-font-smoothing: antialiased;";
            $button_style['mike'] = "background-color: hsl(195, 60%, 35%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#2d95b7', endColorstr='#23748e'); background-image: -khtml-gradient(linear, left top, left bottom, from(#2d95b7), to(#23748e)); background-image: -moz-linear-gradient(top, #2d95b7, #23748e); background-image: -ms-linear-gradient(top, #2d95b7, #23748e); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2d95b7), color-stop(100%, #23748e)); background-image: -webkit-linear-gradient(top, #2d95b7, #23748e); background-image: -o-linear-gradient(top, #2d95b7, #23748e); background-image: linear-gradient(#2d95b7, #23748e); border-color: #23748e #23748e hsl(195, 60%, 32.5%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.16); -webkit-font-smoothing: antialiased;";
            $button_style['delta'] = "background-color: hsl(312, 80%, 43%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e727c0', endColorstr='#c515a2'); background-image: -khtml-gradient(linear, left top, left bottom, from(#e727c0), to(#c515a2)); background-image: -moz-linear-gradient(top, #e727c0, #c515a2); background-image: -ms-linear-gradient(top, #e727c0, #c515a2); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #e727c0), color-stop(100%, #c515a2)); background-image: -webkit-linear-gradient(top, #e727c0, #c515a2); background-image: -o-linear-gradient(top, #e727c0, #c515a2); background-image: linear-gradient(#e727c0, #c515a2); border-color: #c515a2 #c515a2 hsl(312, 80%, 40.5%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.16); -webkit-font-smoothing: antialiased;";
            $button_style['india'] = "background-color: hsl(214, 37%, 28%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7a99c1', endColorstr='#2c4361'); background-image: -khtml-gradient(linear, left top, left bottom, from(#7a99c1), to(#2c4361)); background-image: -moz-linear-gradient(top, #7a99c1, #2c4361); background-image: -ms-linear-gradient(top, #7a99c1, #2c4361); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #7a99c1), color-stop(100%, #2c4361)); background-image: -webkit-linear-gradient(top, #7a99c1, #2c4361); background-image: -o-linear-gradient(top, #7a99c1, #2c4361); background-image: linear-gradient(#7a99c1, #2c4361); border-color: #2c4361 #2c4361 hsl(214, 37%, 19.5%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.56); -webkit-font-smoothing: antialiased;";
            $button_style['november'] = "background-color: hsl(0, 100%, 82%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fecccc', endColorstr='#fea3a3'); background-image: -khtml-gradient(linear, left top, left bottom, from(#fecccc), to(#fea3a3)); background-image: -moz-linear-gradient(top, #fecccc, #fea3a3); background-image: -ms-linear-gradient(top, #fecccc, #fea3a3); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fecccc), color-stop(100%, #fea3a3)); background-image: -webkit-linear-gradient(top, #fecccc, #fea3a3); background-image: -o-linear-gradient(top, #fecccc, #fea3a3); background-image: linear-gradient(#fecccc, #fea3a3); border-color: #fea3a3 #fea3a3 hsl(0, 100%, 80%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.13); -webkit-font-smoothing: antialiased;";
            $button_style['echo'] = "background-color: hsl(110, 56%, 16%) !important;background-repeat: repeat-x;filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#398f28', endColorstr='#193f11');background-image: -khtml-gradient(linear, left top, left bottom, from(#398f28), to(#193f11));background-image: -moz-linear-gradient(top, #398f28, #193f11);background-image: -ms-linear-gradient(top, #398f28, #193f11);background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #398f28), color-stop(100%, #193f11));background-image: -webkit-linear-gradient(top, #398f28, #193f11);background-image: -o-linear-gradient(top, #398f28, #193f11);background-image: linear-gradient(#398f28, #193f11);border-color: #193f11 #193f11 hsl(110, 56%, 11%);color: #fff !important;text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33);-webkit-font-smoothing: antialiased;";
            $button_style['juliet'] = "background-color: hsl(41, 85%, 35%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#efb73d', endColorstr='#a5750d'); background-image: -khtml-gradient(linear, left top, left bottom, from(#efb73d), to(#a5750d)); background-image: -moz-linear-gradient(top, #efb73d, #a5750d); background-image: -ms-linear-gradient(top, #efb73d, #a5750d); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #efb73d), color-stop(100%, #a5750d)); background-image: -webkit-linear-gradient(top, #efb73d, #a5750d); background-image: -o-linear-gradient(top, #efb73d, #a5750d); background-image: linear-gradient(#efb73d, #a5750d); border-color: #a5750d #a5750d hsl(41, 85%, 29%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.39); -webkit-font-smoothing: antialiased;";
            $button_style['oscar'] = "background-color: hsl(70, 11%, 23%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7b7f66', endColorstr='#3e4134'); background-image: -khtml-gradient(linear, left top, left bottom, from(#7b7f66), to(#3e4134)); background-image: -moz-linear-gradient(top, #7b7f66, #3e4134); background-image: -ms-linear-gradient(top, #7b7f66, #3e4134); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #7b7f66), color-stop(100%, #3e4134)); background-image: -webkit-linear-gradient(top, #7b7f66, #3e4134); background-image: -o-linear-gradient(top, #7b7f66, #3e4134); background-image: linear-gradient(#7b7f66, #3e4134); border-color: #3e4134 #3e4134 hsl(70, 11%, 17.5%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.36); -webkit-font-smoothing: antialiased;";

            $style = "float: left; padding: 4px 12px; -webkit-border-radius: 4px; border-radius: 4px; font-size: 14px; margin-top: 0px; text-decoration: none; display: inline-block; border-top-style: solid; border-top-width: 1px;";
            $style += $button_style[jQuery(this).val()];

            jQuery('#button .button_sample').attr("style", $style);
        } else {
            //jQuery('#button select[name=type]').removeAttr('disabled');
            jQuery('#button select[name=type]').addClass('attr-info');
            jQuery('#button select[name=type]').removeClass('display_none');
            jQuery('#button select[name=type]').parent().parent().prev().removeClass('display_none');

            jQuery('#button .button_sample').attr("style", "display: none");
        }
    });
    
    jQuery('#box_wh_content select[name=custom_type]').change(function(){
        $style_id = this.value;
        if($style_id == 'custom') {
            jQuery('#box_wh_content #box_wh_content_custom').attr("style", "display: inline-block");
            jQuery('#box_wh_content #box_wh_content_type').attr("style", "display: none");
            return;
        }
        jQuery('#box_wh_content #box_wh_content_custom').attr("style", "display: none");
        jQuery('#box_wh_content #box_wh_content_type').attr("style", "display: inline-block");
        $style = new Array();
        $style['alpha'] = "background-color: hsl(193, 32%, 49%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b8d3da', endColorstr='#5493a4'); background-image: -khtml-gradient(linear, left top, left bottom, from(#b8d3da), to(#5493a4)); background-image: -moz-linear-gradient(top, #b8d3da, #5493a4); background-image: -ms-linear-gradient(top, #b8d3da, #5493a4); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #b8d3da), color-stop(100%, #5493a4)); background-image: -webkit-linear-gradient(top, #b8d3da, #5493a4); background-image: -o-linear-gradient(top, #b8d3da, #5493a4); background-image: linear-gradient(#b8d3da, #5493a4); border-color: #5493a4 #5493a4 hsl(193, 32%, 41.5%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.49); -webkit-font-smoothing: antialiased;";
        $style['foxtrot'] = "background-color: hsl(0, 69%, 22%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b42121', endColorstr='#5e1111'); background-image: -khtml-gradient(linear, left top, left bottom, from(#b42121), to(#5e1111)); background-image: -moz-linear-gradient(top, #b42121, #5e1111); background-image: -ms-linear-gradient(top, #b42121, #5e1111); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #b42121), color-stop(100%, #5e1111)); background-image: -webkit-linear-gradient(top, #b42121, #5e1111); background-image: -o-linear-gradient(top, #b42121, #5e1111); background-image: linear-gradient(#b42121, #5e1111); border-color: #5e1111 #5e1111 hsl(0, 69%, 17%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33); -webkit-font-smoothing: antialiased;";
        $style['kilo'] = "background-color: hsl(0, 0%, 79%);background-repeat: repeat-x;background-image: -khtml-gradient(linear, left top, left bottom, from(hsl(0, 0%, 121%)), to(hsl(0, 0%, 79%)));background-image: -moz-linear-gradient(top, hsl(0, 0%, 121%), hsl(0, 0%, 79%));background-image: -ms-linear-gradient(top, hsl(0, 0%, 121%), hsl(0, 0%, 79%));background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, hsl(0, 0%, 121%)), color-stop(100%, hsl(0, 0%, 79%)));background-image: -webkit-linear-gradient(top, hsl(0, 0%, 121%), hsl(0, 0%, 79%));background-image: -o-linear-gradient(top, hsl(0, 0%, 121%), hsl(0, 0%, 79%));background-image: linear-gradient(hsl(0, 0%, 121%), hsl(0, 0%, 79%));border-color: hsl(0, 0%, 79%) hsl(0, 0%, 79%) hsl(0, 0%, 68.5%);color: #333;text-shadow: 0 1px 1px rgba(255, 255, 255, 0.69);-webkit-font-smoothing: antialiased;";
        $style['bravo'] = "background-color: hsl(36, 100%, 40%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffad32', endColorstr='#cc7a00'); background-image: -khtml-gradient(linear, left top, left bottom, from(#ffad32), to(#cc7a00)); background-image: -moz-linear-gradient(top, #ffad32, #cc7a00); background-image: -ms-linear-gradient(top, #ffad32, #cc7a00); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #ffad32), color-stop(100%, #cc7a00)); background-image: -webkit-linear-gradient(top, #ffad32, #cc7a00); background-image: -o-linear-gradient(top, #ffad32, #cc7a00); background-image: linear-gradient(#ffad32, #cc7a00); border-color: #cc7a00 #cc7a00 hsl(36, 100%, 35%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.33); -webkit-font-smoothing: antialiased;";
        $style['golf'] = "background-color: hsl(195, 79%, 43%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#56c5eb', endColorstr='#1798c4'); background-image: -khtml-gradient(linear, left top, left bottom, from(#56c5eb), to(#1798c4)); background-image: -moz-linear-gradient(top, #56c5eb, #1798c4); background-image: -ms-linear-gradient(top, #56c5eb, #1798c4); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #56c5eb), color-stop(100%, #1798c4)); background-image: -webkit-linear-gradient(top, #56c5eb, #1798c4); background-image: -o-linear-gradient(top, #56c5eb, #1798c4); background-image: linear-gradient(#56c5eb, #1798c4); border-color: #1798c4 #1798c4 hsl(195, 79%, 38%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.33); -webkit-font-smoothing: antialiased;";
        $style['lima'] = "background-color: hsl(145, 62%, 68%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#cdf3dd', endColorstr='#7adfa4'); background-image: -khtml-gradient(linear, left top, left bottom, from(#cdf3dd), to(#7adfa4)); background-image: -moz-linear-gradient(top, #cdf3dd, #7adfa4); background-image: -ms-linear-gradient(top, #cdf3dd, #7adfa4); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #cdf3dd), color-stop(100%, #7adfa4)); background-image: -webkit-linear-gradient(top, #cdf3dd, #7adfa4); background-image: -o-linear-gradient(top, #cdf3dd, #7adfa4); background-image: linear-gradient(#cdf3dd, #7adfa4); border-color: #7adfa4 #7adfa4 hsl(145, 62%, 63%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.33); -webkit-font-smoothing: antialiased;";
        $style['charlie'] = "background-color: hsl(86, 79%, 44%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#daf6b5', endColorstr='#7cc817'); background-image: -khtml-gradient(linear, left top, left bottom, from(#daf6b5), to(#7cc817)); background-image: -moz-linear-gradient(top, #daf6b5, #7cc817); background-image: -ms-linear-gradient(top, #daf6b5, #7cc817); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #daf6b5), color-stop(100%, #7cc817)); background-image: -webkit-linear-gradient(top, #daf6b5, #7cc817); background-image: -o-linear-gradient(top, #daf6b5, #7cc817); background-image: linear-gradient(#daf6b5, #7cc817); border-color: #7cc817 #7cc817 hsl(86, 79%, 34%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.66); -webkit-font-smoothing: antialiased;";
        $style['hotel'] = "background-color: hsl(0, 0%, 16%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#5b5b5b', endColorstr='#282828'); background-image: -khtml-gradient(linear, left top, left bottom, from(#5b5b5b), to(#282828)); background-image: -moz-linear-gradient(top, #5b5b5b, #282828); background-image: -ms-linear-gradient(top, #5b5b5b, #282828); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #5b5b5b), color-stop(100%, #282828)); background-image: -webkit-linear-gradient(top, #5b5b5b, #282828); background-image: -o-linear-gradient(top, #5b5b5b, #282828); background-image: linear-gradient(#5b5b5b, #282828); border-color: #282828 #282828 hsl(0, 0%, 11%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.33); -webkit-font-smoothing: antialiased;";
        $style['mike'] = "background-color: hsl(195, 60%, 35%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#2d95b7', endColorstr='#23748e'); background-image: -khtml-gradient(linear, left top, left bottom, from(#2d95b7), to(#23748e)); background-image: -moz-linear-gradient(top, #2d95b7, #23748e); background-image: -ms-linear-gradient(top, #2d95b7, #23748e); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #2d95b7), color-stop(100%, #23748e)); background-image: -webkit-linear-gradient(top, #2d95b7, #23748e); background-image: -o-linear-gradient(top, #2d95b7, #23748e); background-image: linear-gradient(#2d95b7, #23748e); border-color: #23748e #23748e hsl(195, 60%, 32.5%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.16); -webkit-font-smoothing: antialiased;";
        $style['delta'] = "background-color: hsl(312, 80%, 43%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#e727c0', endColorstr='#c515a2'); background-image: -khtml-gradient(linear, left top, left bottom, from(#e727c0), to(#c515a2)); background-image: -moz-linear-gradient(top, #e727c0, #c515a2); background-image: -ms-linear-gradient(top, #e727c0, #c515a2); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #e727c0), color-stop(100%, #c515a2)); background-image: -webkit-linear-gradient(top, #e727c0, #c515a2); background-image: -o-linear-gradient(top, #e727c0, #c515a2); background-image: linear-gradient(#e727c0, #c515a2); border-color: #c515a2 #c515a2 hsl(312, 80%, 40.5%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.16); -webkit-font-smoothing: antialiased;";
        $style['india'] = "background-color: hsl(214, 37%, 28%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7a99c1', endColorstr='#2c4361'); background-image: -khtml-gradient(linear, left top, left bottom, from(#7a99c1), to(#2c4361)); background-image: -moz-linear-gradient(top, #7a99c1, #2c4361); background-image: -ms-linear-gradient(top, #7a99c1, #2c4361); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #7a99c1), color-stop(100%, #2c4361)); background-image: -webkit-linear-gradient(top, #7a99c1, #2c4361); background-image: -o-linear-gradient(top, #7a99c1, #2c4361); background-image: linear-gradient(#7a99c1, #2c4361); border-color: #2c4361 #2c4361 hsl(214, 37%, 19.5%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.56); -webkit-font-smoothing: antialiased;";
        $style['november'] = "background-color: hsl(0, 100%, 82%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fecccc', endColorstr='#fea3a3'); background-image: -khtml-gradient(linear, left top, left bottom, from(#fecccc), to(#fea3a3)); background-image: -moz-linear-gradient(top, #fecccc, #fea3a3); background-image: -ms-linear-gradient(top, #fecccc, #fea3a3); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fecccc), color-stop(100%, #fea3a3)); background-image: -webkit-linear-gradient(top, #fecccc, #fea3a3); background-image: -o-linear-gradient(top, #fecccc, #fea3a3); background-image: linear-gradient(#fecccc, #fea3a3); border-color: #fea3a3 #fea3a3 hsl(0, 100%, 80%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.13); -webkit-font-smoothing: antialiased;";
        $style['echo'] = "background-color: hsl(0, 100%, 82%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fecccc', endColorstr='#fea3a3'); background-image: -khtml-gradient(linear, left top, left bottom, from(#fecccc), to(#fea3a3)); background-image: -moz-linear-gradient(top, #fecccc, #fea3a3); background-image: -ms-linear-gradient(top, #fecccc, #fea3a3); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fecccc), color-stop(100%, #fea3a3)); background-image: -webkit-linear-gradient(top, #fecccc, #fea3a3); background-image: -o-linear-gradient(top, #fecccc, #fea3a3); background-image: linear-gradient(#fecccc, #fea3a3); border-color: #fea3a3 #fea3a3 hsl(0, 100%, 80%); color: #333 !important; text-shadow: 0 1px 1px rgba(255, 255, 255, 0.13); -webkit-font-smoothing: antialiased;";
        $style['juliet'] = "background-color: hsl(41, 85%, 35%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#efb73d', endColorstr='#a5750d'); background-image: -khtml-gradient(linear, left top, left bottom, from(#efb73d), to(#a5750d)); background-image: -moz-linear-gradient(top, #efb73d, #a5750d); background-image: -ms-linear-gradient(top, #efb73d, #a5750d); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #efb73d), color-stop(100%, #a5750d)); background-image: -webkit-linear-gradient(top, #efb73d, #a5750d); background-image: -o-linear-gradient(top, #efb73d, #a5750d); background-image: linear-gradient(#efb73d, #a5750d); border-color: #a5750d #a5750d hsl(41, 85%, 29%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.39); -webkit-font-smoothing: antialiased;";
        $style['oscar'] = "background-color: hsl(70, 11%, 23%) !important; background-repeat: repeat-x; filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#7b7f66', endColorstr='#3e4134'); background-image: -khtml-gradient(linear, left top, left bottom, from(#7b7f66), to(#3e4134)); background-image: -moz-linear-gradient(top, #7b7f66, #3e4134); background-image: -ms-linear-gradient(top, #7b7f66, #3e4134); background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #7b7f66), color-stop(100%, #3e4134)); background-image: -webkit-linear-gradient(top, #7b7f66, #3e4134); background-image: -o-linear-gradient(top, #7b7f66, #3e4134); background-image: linear-gradient(#7b7f66, #3e4134); border-color: #3e4134 #3e4134 hsl(70, 11%, 17.5%); color: #fff !important; text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.36); -webkit-font-smoothing: antialiased;";
        jQuery('#box_wh_content .header_bg').attr("style", $style[$style_id]);
    });
});
