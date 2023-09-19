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

    @if(isset($folder) && isset($folder->short))
        <div class="row">
            <div class="col-12">
                <p class="text-muted">
                    {{ $folder->short }}
                </p>
            </div>
        </div>
    @endif

    @if($folders->count() > 0)
        <div class="row">
            @foreach ($folders as $item)
                <div class="{{ $col }} folder-teaser-cover">
                    @include("site-pages::site.folders.includes.teaser", ["folder" => $item , "grid" => $grid])
                </div>
            @endforeach
        </div>
    @endif

    @if(isset($folder) && isset($folder->description))
        <div class="row">
            <div class="col-12">
                {!! $folder->description !!}
            </div>
        </div>
    @endif
@endsection
@push("svg")
    @includeIf("site-pages::layouts.svg")
@endpush
