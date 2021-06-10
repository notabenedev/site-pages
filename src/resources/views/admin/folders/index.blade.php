@extends("admin.layout")

@section("page-title", config("site-pages.siteFoldersName")." - ".config("site-pages.sitePackageName")." - ")

@section('header-title', config("site-pages.siteFoldersName"))

@section('admin')
    @include("site-pages::admin.folders.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($isTree)
{{--                    @include("site-pages::admin.folders.includes.tree", ["categories" => $categories])--}}
                @else
                    @include("site-pages::admin.folders.includes.table-list", ["folders" => $folders])
                @endif
            </div>
        </div>
    </div>
@endsection