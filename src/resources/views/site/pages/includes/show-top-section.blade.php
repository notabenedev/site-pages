<div class="col-12 col-lg-6">
    <div class="page-gallery-top  js-flickity" id="pageGalleryTop{{ $page->slug }}"
         data-flickity-options='{
         "prevNextButtons": false,
         "pageDots": false,
         "imagesLoaded": true,
         "percentPosition": false,
          "adaptiveHeight": true,
          "resize": true,
           "setGallerySize": true
{{--         "wrapAround": true,--}}
{{--         "draggable": false,--}}
{{--         "resize": true,--}}
{{--         "setGallerySize": false,--}}
{{--         "percentPosition": false--}}
         } '>
        @isset($page->image)
            <div class="carousel-cell">
                @img([
                "image" => $page->image,
                "template" => "pages-grid-sm-12",
                "lightbox" => "lightGroupPage".$page->id,
                "grid" => [
                "pages-grid-xl-6" => 1200,
                "pages-grid-lg-6" => 992,
                "pages-grid-md-12" => 768,
                ],
                "imgClass" => "img-fluid rounded",
                ])
            </div>
        @endisset
        @foreach ($gallery as $item)
            <div class="carousel-cell">
                @img([
                    "image" => $item,
                    "template" => "pages-grid-sm-12",
                    "lightbox" => "lightGroupPage".$page->id,
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

    @if (($page->image && $gallery->count() >= 1) || $gallery->count() >= 2)
        <div class="page-gallery-thumbs  js-flickity" id="pageGalleryThumbs{{ $page->slug }}"
             data-flickity-options='{
             "prevNextButtons": false,
             "pageDots": false,
             "asNavFor": "#pageGalleryTop{{ $page->slug }}",
             "freeScroll": true,
             "contain": true,
             "resize": true
{{--             "cellAlign": "left",--}}
{{--              "percentPosition": false--}}
             }'>
            @isset($page->image)
                <div class="carousel-cell">
                    @pic([
                    "image" => $page->image,
                    "template" => "pages-show-thumb",
                    "grid" => [],
                    "imgClass" => "img-fluid rounded",
                    ])
                </div>
            @endisset
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

        @if(config("site-pages.sitePageShowBtnName"))
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
            <p class="text-right">
                <button class="collapse multi-collapse btn btn-secondary"
                        type="button"
                        id="collapseFormBtnHide"
                        data-toggle="collapse"
                        data-target=".multi-collapse"
                        aria-expanded="false"
                        aria-controls="collapseFormContainer collapseFormBtnShow"
                title="Закрыть">
                    <i class="fas fa-times"></i>
                </button>
            </p>
            <div class="collapse multi-collapse page-show__collapse" id="collapseFormContainer">
                @includeIf("site-pages::site.pages.includes.form", ["title" => $page->title, "folder" => $page->folder->title])
            </div>

        @endif

        <div class="description page-show__description">
            {!! $page->description !!}
        </div>
        @isset($page->comment)
            <div class="page-show__comment">
                {!! $page->comment !!}
            </div>
        @endisset



    </div>
</div>