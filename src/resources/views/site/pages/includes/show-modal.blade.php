<!-- Modal -->
<div class="modal fade showPageModal" id="showPage{{ $page->slug }}Modal" tabindex="-1" aria-labelledby="showPage{{ $page->slug }}ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl page-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title d-lg-none" id="showPage{{ $page->slug }}ModalLabel">{{ $page->title }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-0">
                <div class="row page-show">
                    <div class="col-12">
                        <div class="page-show__cover">
                    @include("site-pages::site.pages.includes.show-top-section", [
                 "modal" => true,
                  "page" => $page,
                  "gallery" => $page->images()->orderBy("weight")->get()
                 ])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>