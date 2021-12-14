<div class="col-12 col-lg-6">
    <div class="page-gallery-top">
        @foreach ($gallery as $item)
            <div class="carousel-cell">
                @img([
                    "image" => $item,
                    "template" => "pages-grid-sm-12",
                    "lightbox" => "lightGroupPage",
                    "grid" => [
                        "pages-grid-xl-6" => 1200,
                        "pages-grid-lg-6" => 992,
                        "pages-grid-md-12" => 768,
                    ],
                    "imgClass" => "img-fluid rounded",
                ])
            </div>
        @endforeach
    </div>

    @if ($gallery->count() >= 2)
        <div class="page-gallery-thumbs">
            @foreach ($gallery as $item)
                <div class="carousel-cell">
                    @pic([
                    "image" => $item,
                    "template" => "pages-show-thumb",
                    "grid" => [],
                    "imgClass" => "img-fluid rounded",
                    ])
                </div>
            @endforeach
        </div>
    @endif
</div>
<div class="col-12 col-lg-6">
    <div class="page-show__text-cover">
        <h1 class="page-show__title">{{ $page->title }}</h1>
        @isset($page->short)
            <div class="page-show__short">
                {{ $page->short }}
            </div>
        @endisset
        @isset($page->accent)
            <div class="page-show__accent">
                {{ $page->accent }}
            </div>
        @endisset
        <p>
            <button class="collapse show page-show__btn btn btn-primary"
               id="collapseFormBtnShow"
               data-toggle="collapse"
               data-target=".multi-collapse"
               role="button"
               aria-expanded="false"
               aria-controls="collapseForm">
                {{ config("site-pages.sitePageShowBtnName") }}
            </button>
        </p>
        <div class="collapse multi-collapse page-show__collapse" id="collapseFormContainer">
            form

        </div>
        <p>
            <button class="collapse multi-collapse btn btn-secondary"
                    type="button"
                    id="collapseFormBtnHide"
                    data-toggle="collapse"
                    data-target=".multi-collapse"
                    aria-expanded="false"
                    aria-controls="collapseFormContainer collapseFormBtnShow">
                Закрыть
            </button>
        </p>

        <div class="description page-show__description">
            {!! $page->description !!}
        </div>
        @isset($page->comment)
            <div class="page-show__comment">
                {{ $page->comment }}
            </div>
        @endisset



    </div>
</div>