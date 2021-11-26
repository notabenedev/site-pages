@extends("admin.layout")

@section("page-title", "Галерея - ")

@section('header-title', "{$page->title}")

@section('admin')
    @include("site-pages::admin.pages.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <gallery csrf-token="{{ csrf_token() }}"
                         upload-url="{{ route('admin.vue.gallery.post', ['id' => $page->id, 'model' => 'pages']) }}"
                         get-url="{{ route('admin.vue.gallery.get', ['id' => $page->id, 'model' => 'pages']) }}">
                </gallery>
            </div>
        </div>
    </div>
@endsection