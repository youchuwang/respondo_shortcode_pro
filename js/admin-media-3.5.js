var respondo_media_frame;
jQuery(document).ready(function () {
    jQuery("body").on("click", ".file-upload-btn-rs",function(){
		if ( respondo_media_frame ) {
            respondo_media_frame.open();
            return;
        } else {
            respondo_media_frame = wp.media.frames.respondo_media_frame = wp.media({
                className: 'media-frame respondo-media-frame',
                frame: 'select',
                multiple: false,
                title: respondo_media.title,
                library: {
                    type: 'image'
                },
                button: {
                    text:  respondo_media.button
                },
                displaySettings: true,
                displayUserSettings: true
            });
            respondo_media_frame.open();
        }
		
        $obj = this;

        respondo_media_frame.on('select', function(){
            // Grab our attachment selection and construct a JSON representation of the model.
            var media_attachment = respondo_media_frame.state().get('selection').first().toJSON();
            jQuery('input[name=img_url]', jQuery($obj).parent()).val(media_attachment.url);
            jQuery('input[name=alt]', jQuery($obj).parent().parent().parent()).val(media_attachment.alt);
            jQuery('input[name=img_url]', jQuery($obj).parent()).css('border-color', '#dfdfdf');

            // Send the attachment URL to our custom input field via jQuery.
            //jQuery('#tgm-new-media-image').val(media_attachment.url);
            respondo_media_frame = false;
        });

    // Now that everything has been set, let's open up the frame.
    });
	
	jQuery("body").on("click", ".file-upload-btn-multi-rs",function(){
		if ( respondo_media_frame ) {
            respondo_media_frame.open();
            return;
        } else {
            respondo_media_frame = wp.media.frames.respondo_media_frame = wp.media({
                className: 'media-frame respondo-media-frame',
                frame: 'select',
                multiple: false,
                title: respondo_media.title,
                library: {
                    type: 'image'
                },
                button: {
                    text:  respondo_media.button
                },
                displaySettings: true,
                displayUserSettings: true
            });
            respondo_media_frame.open();
        }
		
        $obj = this;

        respondo_media_frame.on('select', function(){
            // Grab our attachment selection and construct a JSON representation of the model.
            var media_attachment = respondo_media_frame.state().get('selection').first().toJSON();
            jQuery('input[class=attr-info]', jQuery($obj).parent()).val(media_attachment.url);
            jQuery('input[class=attr-info]', jQuery($obj).parent().parent().next().next()).val(media_attachment.alt);

            // Send the attachment URL to our custom input field via jQuery.
            //jQuery('#tgm-new-media-image').val(media_attachment.url);
            respondo_media_frame = false;
        });

    // Now that everything has been set, let's open up the frame.
    });
});
