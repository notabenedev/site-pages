@extends("layouts.boot")

@section('page-title', "{$folder->title} - ")

@section("header-title", "{$folder->title}")

@section("contents")
    @isset($folder->short)
    <div class="row">
        <div class="col-12">
            <p class="text-muted">
                {{ $folder->short }}
            </p>
        </div>
    </div>
    @endisset

    @if ($folders->count())
        @include("site-pages::site.folders.includes.children", ["children" => $folders])
    @endif

    @include("site-pages::site.pages.includes.grid", ["pages" => $pages])

    @isset($folder->description)
        <div class="row">
            <div class="col-12">
                {!! $folder->description  !!}
            </div>
        </div>
    @endisset

    @if ($pages->lastPage() > 1)
        <div class="row">
            <div class="col-12">
                {{ $pages->links() }}
            </div>
        </div>
    @endif
    @include("site-pages::site.folders.includes.show-modal")
@endsection
@push("svg")
    @includeIf("site-pages::layouts.svg")
@endpush