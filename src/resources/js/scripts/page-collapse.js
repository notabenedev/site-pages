(function ($) {
    $(document).ready(function(){
        hideShowFormBtn('#collapseFormContainer','#collapseFormBtnShow')
    });

    function hideShowFormBtn($collapseId, $collapseBtnId) {
        if($($collapseId).length){
            $($collapseId).on('show.bs.collapse', function() {
                $($collapseBtnId).hide();
            });
            $($collapseId).on('hide.bs.collapse', function() {
                $($collapseBtnId).show();
            })
        }
    }
})(jQuery);