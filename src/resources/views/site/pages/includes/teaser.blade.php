<div class="card page-teaser h-100">
    <div class="page-teaser__image-cover">
        <a class="page-teaser__image-lnk"
           @if (config("site-pages.showPageModal"))
           data-toggle="modal"
           data-target="#showPage{{ $page->slug }}Modal"
           href="#"
           @else
           href="{{ route("site.pages.show", ["page" => $page]) }}"
           @endif
        >
{{--  use image->cover for first gallery's image --}}
            @if ($page->image)
                @pic([
                    "image" => $page->image,
                    "template" => "pages-grid-sm-12",
                    "grid" => $grid,
                    "imgClass" => "card-img-top page-teaser__image",
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
            @if(! config("site-pages.siteSimplePageSimpleTeaser", false))
                @if ($page->accent)
                    <div class="page-teaser__accent">{{ $page->accent }}</div>
                @endif
            @endif
        </div>
    </div>
    @if(! config("site-pages.siteSimplePageSimpleTeaser", false))
        <div class="card-footer page-teaser__footer">
            @include("site-pages::site.pages.includes.teaser-footer")
        </div>
        @endif
</div>
@if (config("site-pages.showPageModal"))
    @include("site-pages::site.pages.includes.show-modal", [
    "page" => $page,
    ])
@endif