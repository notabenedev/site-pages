(function ($) {
    $(document).ready(function (event) {
        modalPageData('#getPageQuestionModal');
    });

    function modalPageData($id) {
        if ($($id).length){
            $($id).on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var recipient = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('#input-whatever').val(recipient)
                // var $gallery = modal.find('.page-gallery-top');
                // $gallery.flickity('reloadCells');
                // var $gallery = modal.find('.page-gallery-thumbs');
                // $gallery.flickity('reloadCells');
            })
        }
    }

})(jQuery);