<div class="card page-teaser h-100">
    <div class="page-teaser__image-cover">
        <a class="page-teaser__image"
           @if (config("site-pages.showPageModal"))
           data-toggle="modal"
           data-target="#showPage{{ $page->slug }}Modal"
           href="#"
           @else
           href="{{ route("site.pages.show", ["page" => $page]) }}"
           @endif
        >
            @if ($page->cover)
                @pic([
                    "image" => $page->cover,
                    "template" => "pages-grid-sm-12",
                    "grid" => $grid,
                    "imgClass" => "card-img-top",
                ])
            @else
                <div class="page-teaser__image-empty">
                    <svg class="page-teaser__image-empty__ico">
                        <use xlink:href="#page-image-empty"></use>
                    </svg>
                </div>
            @endif
        </a>
    </div>
    <div class="card-body page-teaser__body">
        <div class="page-teaser__info">
            <a class="page-teaser__title"
               @if (config("site-pages.showPageModal"))
               data-toggle="modal"
               data-target="#showPage{{ $page->slug }}Modal"
               href="#"
               @else
               href="{{ route("site.pages.show", ["page" => $page]) }}"
                    @endif>
                {{ $page->title }}
            </a>
            @if ($page->short)
                <div class="page-teaser__short">{{ $page->short }}</div>
            @endif
            @if ($page->accent)
                <div class="page-teaser__price">{{ $page->accent }}</div>
            @endif
        </div>
    </div>
    <div class="card-footer page-teaser__footer">
        @include("site-pages::site.pages.includes.teaser-footer")
    </div>
</div>
@if (config("site-pages.showPageModal"))
    @include("site-pages::site.pages.includes.show-modal", [
    "page" => $page,
    ])
@endif