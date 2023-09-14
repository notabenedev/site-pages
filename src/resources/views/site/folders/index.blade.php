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
    @isset($folder)
        <div class="row">
            <div class="col-12">
                <p class="text-muted">
                    {{ $folder->short }}
                </p>
            </div>
        </div>
    @endisset
    <div class="row">
        @foreach ($folders as $item)
            <div class="{{ $col }} folder-teaser-cover">
                @include("site-pages::site.folders.includes.teaser", ["folder" => $item , "grid" => $grid])
            </div>
        @endforeach
    </div>
    @isset($folder)
        <div class="row">
            <div class="col-12">
                {!! $folder->description !!}
            </div>
        </div>
    @endisset
@endsection
@push("svg")
    @includeIf("site-pages::layouts.svg")
@endpush