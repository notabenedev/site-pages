@extends("layouts.boot")

@section('page-title', "{$folder->title} - ")

@section("header-title", "{$folder->title}")

@section("contents")
    @if ($folders->count())
        @include("site-pages::site.folders.includes.children", ["children" => $folders])
    @endif

{{--    @include("site-pages::site.pages.includes.grid", ["pages" => $pages])--}}

{{--    @if ($pages->lastPage() > 1)--}}
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                {{ $pages->links() }}--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
@endsection
