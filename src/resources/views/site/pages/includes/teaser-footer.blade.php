<div class="d-flex flex-row">
    <div class="mr-auto">
        <a class="btn btn-primary page-teaser__btn"
           @if (config("site-pages.showPageModal"))
           data-toggle="modal"
           data-target="#getPageOrderModal"
           data-whatever="{{ $page->id }}"
           href="#"
           @else
           href="{{ route("site.pages.show", ["page" => $page]) }}"
                @endif
        >
            Подробнее
        </a>
    </div>

    <div class="btn ml-auto">
        <a href="#"
           data-toggle="modal"
           data-target="#getPageQuestionModal"
           data-whatever="{{ $page->title }}">
            Задать вопрос
        </a>
    </div>
</div>

