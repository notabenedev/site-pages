<div class="sticky-top">
    @if(!empty($img))
        @pic([
        "image" => $img,
        "template" => "pages-grid-sm-12",
        "grid" => [
        "pages-grid-xxl-4" => 1400,
        "pages-grid-xl-4" => 1200,
        "pages-grid-lg-4" => 992,
        "pages-grid-md-12" => 768,
        ],
        "imgClass" => "img-fluid rounded mb-4",
        ])
    @endisset
    <div class="page-simple__form">
        @if(config("site-pages.siteSimplePageFormHeader", false))
            <h3 class="h3 page-simple__form_header">{{ config("site-pages.siteSimplePageFormHeader") }}</h3>
        @endif
        @include('site-pages::site.pages.includes.form-question',["title" => $title])
    </div>
</div>


