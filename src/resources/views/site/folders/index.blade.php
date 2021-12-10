@extends("layouts.boot")

@section('page-title')
    @empty($folder)
        {{ config("site-pages.sitePackageName") }} -
    @else
        {{ $folder->title }} -
    @endempty
@endsection

@section("header-title")
    @empty($folder)
        {{ config("site-pages.sitePackageName") }}
    @else
        {{ $folder->title }}
    @endempty
@endsection

@section("contents")
    <div class="row">
        @php
            $colLg = config("site-pages.foldersLgGrid");
            switch ($colLg){
            case "4":
            $col = "col-12 col-sm-6 col-lg-4";
            $grid = [
            "pages-grid-sm-6" => 576,
            "pages-grid-md-6" => 768,
            "pages-grid-lg-6" => 992,
            "pages-grid-xl-6" => 992,
            ];
            break;

            case "6":
            $col = "col-12 col-md-6";
            $grid = [
            "pages-grid-sm-12" => 576,
            "pages-grid-md-6" => 768,
            "pages-grid-lg-6" => 992,
            "pages-grid-xl-6" => 992,
            ];
            break;

            }
            $count = count($folders);

        @endphp

        @foreach ($folders as $item)
            <div class="{{ $col }} folder-teaser-cover">
                @include("site-pages::site.folders.includes.teaser", ["folder" => $item , "grid" => $grid])
            </div>
        @endforeach
    </div>
@endsection
@push("svg")
    @includeIf("site-pages::layouts.svg")
@endpush