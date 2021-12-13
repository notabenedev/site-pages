<div class="card page-teaser">
    <div class="page-teaser__image-cover">
        <a href="{{ route("site.pages.show", ["page" => $page]) }}"
           class="page-teaser__image">
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
            <a href="{{ route("site.pages.show", ["page" => $page]) }}" class="page-teaser__title">
                {{ $page->title }}
            </a>
            @if ($page->short)
                <div class="page-teaser__short">{{ $page->short }}</div>
            @endif
            @if ($page->price)
                <div class="page-teaser__price">{{ $page->price }}</div>
            @endif
        </div>
    </div>
    <div class="card-footer page-teaser__footer">
        @include("site-pages::site.pages.includes.teaser-footer")
    </div>
</div>