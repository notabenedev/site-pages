@extends("admin.layout")

@section("page-title", "{$folder->title} - ")

@section('header-title', "{$folder->title}")

@section('admin')
    @include("site-pages::admin.folders.includes.pills")
    @if ($image)
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    @img([
                        "image" => $image,
                        "template" => "medium",
                        "lightbox" => "lightGroup" . $folder->id,
                        "imgClass" => "rounded mb-2",
                        "grid" => [],
                    ])
                </div>
            </div>
        </div>
    @endif
    <div class="{{ $image ? "col-12 col-lg-8" : "col-12" }}">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    @if ($folder->short)
                        <dt class="col-sm-3">Краткое описание</dt>
                        <dd class="col-sm-9">{{ $folder->short }}</dd>
                    @endif
                     @if ($folder->description)
                            <dt class="col-sm-3">Описание</dt>
                            <dd class="col-sm-9">{!! $folder->description !!} </dd>
                      @endif
                    @if ($folder->parent)
                        <dt class="col-sm-3">Родитель</dt>
                        <dd class="col-sm-9">
                            <a href="{{ route("admin.folders.show", ["folder" => $folder->parent]) }}">
                                {{ $folder->parent->title }}
                            </a>
                        </dd>
                    @endif
                    @if ($childrenCount)
                        <dt class="col-sm-3">Дочерние</dt>
                        <dd class="col-sm-9">{{ $childrenCount }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
    @if ($childrenCount)
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Подкатегории</h5>
                </div>
                <div class="card-body">
                    @include("site-pages::admin.folders.includes.table-list", ["folders" => $children])
                </div>
            </div>
        </div>
    @endif
@endsection