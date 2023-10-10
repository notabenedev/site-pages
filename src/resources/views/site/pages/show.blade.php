@extends("layouts.boot")

@section('page-title', "{$page->title} - ")

@section("contents")
    @if (! config("site-pages.siteSimplePage", false))
    <div class="row page-show">
        <div class="col-12">
            <div class="page-show__cover">
                @include("site-pages::site.pages.includes.show-top-section")
            </div>
        </div>
    </div>
    @else
        <div class="row page-simple">
            <div class="col-12">
                @include("site-pages::site.pages.simple.page")
            </div>
        </div>
    @endif
@endsection