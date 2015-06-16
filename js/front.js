jQuery(document).ready(function () {
    jQuery('.rs-gallery.inactive').mouseover(function() {
        jQuery('.left.carousel-control', this).css('display', 'inline');
        jQuery('.right.carousel-control', this).css('display', 'inline');
    });
    
    jQuery('.rs-gallery.inactive').mouseleave(function() {
        jQuery('.left.carousel-control', this).css('display', 'none');
        jQuery('.right.carousel-control', this).css('display', 'none');
    });
    
    
    
    
    
    jQuery('.recent_news_img').hover( function() {
        jQuery(this).stop().animate({
            opacity:0.8
        },{
            queue:false,
            duration:200
        });  
    }, function() {
        jQuery(this).stop().animate({
            opacity:1
        },{
            queue:false,
            duration:200
        });  
    });
    
    jQuery('.recent_news_img a').hover( function() {
        jQuery(this).find('.nb_article_icon ').stop().animate({
            left:0
        },{
            queue:false,
            duration:200
        });  
    }, function() {
        jQuery(this).find('.nb_article_icon ').stop().animate({
            left:'-44px'
        },{
            queue:false,
            duration:200
        });  
    });
/*
    jQuery('img.rs-imgs').each(function() {
        jQuery(this).load(function() {
            if(jQuery(this).attr('style')) {
            } else {
                jQuery(this).attr('style','');
            }
            $width = jQuery(this).width()-10;
            jQuery(this).attr('style', function(i,s) {
                if(s == '')
                    return s + 'width: '+$width+'px !important;';
                else 
                    return s + '; width: '+$width+'px !important;';
            });
        });
    });
* 
*/
});