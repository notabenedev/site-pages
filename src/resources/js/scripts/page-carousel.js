import PageFlickity from "flickity-as-nav-for";
import "flickity/css/flickity.css";

(function ($) {
    $(document).ready(function(){
        setTimeout(initPageCarousel, 1000);
        modalCarousel('.showPageModal');
    });
    function modalCarousel($class) {
        $($class).each(function () {
            $(this).on( 'shown.bs.modal', function( event ) {
                initPageCarousel();
            });
        });
    }
    function initPageCarousel() {
        $(".page-gallery-top").each(function () {
            let top = this;
            let galleryTop = new PageFlickity(top, {
                prevNextButtons: false,
                pageDots: false,
                wrapAround: true,
                cellSelector: '.carousel-cell',
                draggable: false,
                //imagesLoaded: true,
                //percentPosition: false
            });
        });


        $(".page-gallery-thumbs").each(function () {
            let thumb = this;
            let galleryThumbs = new PageFlickity(thumb, {
                prevNextButtons: false,
                pageDots: false,
                asNavFor: ".page-gallery-top",
                 freeScroll: true,
                contain: true,
               // imagesLoaded: true,
                //percentPosition: false,
            });

        });


    }
})(jQuery);