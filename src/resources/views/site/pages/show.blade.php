@extends("layouts.boot")

@section('page-title', "{$page->title} - ")

@section("contents")
    <div class="row page-show">
        <div class="col-12">
            <div class="page-show__cover">
                @include("site-pages::site.pages.includes.show-top-section")
            </div>
        </div>
    </div>
@endsection