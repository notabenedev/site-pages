<!-- Modal -->
<div class="modal fade getPageQuestionModal" id="getPageQuestionModal" tabindex="-1" aria-labelledby="getPageQuestionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="getPageQuestionModalLabel">Задать вопрос</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-12">
                    @include("site-pages::site.pages.includes.form-question", [
                 "modal" => true
                 ])
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>