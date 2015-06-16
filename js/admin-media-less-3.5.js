// media upload
var $btn_str = '<input type="button" id="return_to_rs" name="return_to_rs" class="btn-rs" value="Return" style="position: absolute; top: 32px; right: 30px;" onClick="return_gallery_rs()">';

function return_gallery_rs() {
    $idx = 0;
    jQuery("div[id='TB_title']").each(function () {
        if($idx == 0) {
            jQuery(this).show();
        } else {
            jQuery(this).remove();
        }
        ++$idx;
    });

    jQuery('#TB_ajaxContent').show();
    jQuery('#TB_iframeContent').remove();
}

var storeSendToEditor = '';
var newSendToEditor = '';

jQuery(document).ready(function () {
    var $obj = '';
    var storeSendToEditor = '';
    var newSendToEditor = '';
    // media upload
    jQuery(".file-upload-btn-rs").live('click', function(){
		jQuery("#TB_title").hide();
        jQuery('#TB_ajaxContent').hide();
        window.send_to_editor = newSendToEditor;

        tb_show('Add media', 'media-upload.php?type=image&TB_iframe=true');//&tab=library
        $idx = 0;
        jQuery("div[id='TB_title']").each(function () {
            if(jQuery(this).css("display") != "none") {
                if($idx == 0) {
                    jQuery(this).append($btn_str);
                } else {
                    jQuery(this).remove();
                }
                ++$idx;
            }
        });
        $obj = this;
    });

    storeSendToEditor = window.send_to_editor;

    newSendToEditor = function(html) {
        $p_obj = jQuery($obj).parent();
        imgurl = jQuery('img',html).attr('src');
        jQuery('input[name=img_url]', $p_obj).val(imgurl);
        jQuery('input[name=img_url]', $p_obj).css('border-color', '#dfdfdf');
        return_gallery_rs();
        window.send_to_editor = storeSendToEditor;
    }
});
