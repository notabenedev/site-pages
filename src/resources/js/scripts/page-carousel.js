import PageFlickity from "flickity-as-nav-for";
import "flickity/css/flickity.css";

(function ($) {
    $(document).ready(function(){
        setTimeout(initPageCarousel, 1000);
    });

    function initPageCarousel() {
        if (! $(".page-gallery-top").length) return;

        let top = document.querySelector(".page-gallery-top");
        let galleryTop = new PageFlickity(top, {
            prevNextButtons: false,
            pageDots: false,
            wrapAround: true,
            cellSelector: '.carousel-cell',
            draggable: false
        });

        if (! $(".page-gallery-thumbs").length) return;

        let thumb = document.querySelector(".page-gallery-thumbs");
        let galleryThumbs = new PageFlickity(thumb, {
            prevNextButtons: false,
            pageDots: false,
            asNavFor: ".page-gallery-top",
            freeScroll: true,
            contain: true,
        })
    }
})(jQuery);