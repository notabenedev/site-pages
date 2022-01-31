import Flickity from "flickity";
import jQueryBridget from "jquery-bridget";
import "flickity-as-nav-for";
import "flickity/css/flickity.css";

window.flickity = require('flickity');

(function ($) {

    // make Flickity a jQuery plugin
    Flickity.setJQuery( $ );
    jQueryBridget( 'flickity', Flickity, $ );

    $(document).ready(function(){
        modalCarousel();
    });

    function modalCarousel() {
        $('.showPageModal').each(function () {
            $(this).on( 'shown.bs.modal', function( event ) {
                let pageId = this.id;
                let id = pageId.replace("showPage","");
                id = id.replace("Modal","");
                let topId = "#pageGalleryTop"+id;
                let thumbsId = "#pageGalleryThumbs"+id;
                $(topId).flickity("resize");
                $(thumbsId).flickity("resize");
                //$(window).trigger('resize');
            });
        });
    }


})(jQuery);