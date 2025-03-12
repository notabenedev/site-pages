document.addEventListener('DOMContentLoaded', function(){
    document.querySelectorAll('.page-show__text-cover').forEach(el => {

        var collapses = el.getElementsByClassName("page-show__collapse");
        var btns = el.getElementsByClassName("page-show__btn");

        if (collapses.length & btns.length){
            collapses[0].addEventListener('show.bs.collapse', event => {
                btns[0].classList.add('d-none');
            })
            collapses[0].addEventListener('hide.bs.collapse', event => {
                btns[0].classList.remove('d-none');
            })

        }
    });
});
