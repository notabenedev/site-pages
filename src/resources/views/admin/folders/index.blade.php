@extends("admin.layout")

@section("page-title", "Иерархия - ")

@section('header-title', "Иерархия")

@section('admin')
{{--    @include("site-pages::admin.folders.includes.pills")--}}
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                Test
{{--                @if ($isTree)--}}
{{--                    @include("site-pages::admin.folders.includes.tree", ["categories" => $categories])--}}
{{--                @else--}}
{{--                    @include("site-pages::admin.folders.includes.table-list", ["categories" => $categories])--}}
{{--                @endif--}}
            </div>
        </div>
    </div>
@endsection