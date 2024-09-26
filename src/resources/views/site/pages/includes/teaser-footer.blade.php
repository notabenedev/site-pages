<div class="d-flex flex-row">
    <div class="mr-auto">
        <a class="btn btn-primary page-teaser__btn"
           @if (config("site-pages.showPageModal"))
           data-bs-toggle="modal"
           data-bs-target="#showPage{{ $page->slug }}Modal"
           href="#"
           @else
           href="{{ route("site.pages.show", ["page" => $page]) }}"
                @endif
        >
            Подробнее
        </a>
    </div>

    <div class="my-auto ms-auto text-end">
        <a href="#"
           class="page-teaser__lnk"
           data-bs-toggle="modal"
           data-bs-target="#getPageQuestionModal"
           data-bs-whatever="{{ $page->folder->title .": ". $page->title }}">
            Задать вопрос
        </a>
    </div>
</div>

