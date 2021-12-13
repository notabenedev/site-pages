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