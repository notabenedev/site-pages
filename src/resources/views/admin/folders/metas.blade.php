@extends("admin.layout")

@section("page-title", "{$folder->title} - ")

@section('header-title', "{$folder->title}")

@section('admin')
    @include("site-pages::admin.folders.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Добавить тег</h5>
            </div>
            <div class="card-body">
                @include("seo-integration::admin.meta.create", ['model' => 'folders', 'id' => $folder->id])
            </div>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                @include("seo-integration::admin.meta.table-models", ['metas' => $folder->metas])
            </div>
        </div>
    </div>
@endsection