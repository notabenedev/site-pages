document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.page-show__text-cover').forEach(el => {
        var collapse = el.getElementsByClassName("page-show__collapse")[0];
        var btn = el.getElementsByClassName("page-show__btn")[0];
        if (collapse & btn){
            collapse.addEventListener('show.bs.collapse', event => {
                btn.hide();
            })
            collapse.addEventListener('hide.bs.collapse', event => {
                btn.show();
            })

        }
    });
});
