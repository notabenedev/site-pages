@extends("admin.layout")

@section("page-title", "{$page->title} - ")

@section('header-title', "{$page->title}")

@section('admin')
    @include("site-pages::admin.pages.includes.pills")
    @if ($image)
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    @img([
                    "image" => $image,
                    "template" => "medium",
                    "lightbox" => "lightGroup" . $page->id,
                    "imgClass" => "rounded mb-2",
                    "grid" => [],
                    ])
                </div>
            </div>
        </div>
    @endif
    <div class="col-12">
        <div class="card">
            @can("update", $page)
                <div class="card-header">
                    <button type="button" class="btn btn-warning collapse show collapseChangeFolder" data-toggle="modal" data-target="#changeFolder">
                        Изменить категорию
                    </button>
                    <div class="collapse mt-3 collapseChangeFolder">
                        <form class="form-inline"
                              method="post"
                              action="{{ route("admin.pages.change-folder", ['page' => $page]) }}">
                            @csrf
                            @method('put')
                            <div class="form-group">
                                <label for="folder_id" class="sr-only">Категория </label>
                                <div class="input-group">
                                    <select name="folder_id"
                                            id="folder_id"
                                            class="custom-select">
                                        @foreach($folders as $key => $value)
                                            <option value="{{ $key }}"
                                                    @if ($key == $folder->id)
                                                    selected
                                                    @elseif (old('folder_id'))
                                                    selected
                                                    @endif>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-success" type="submit">Обновить</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endcan
            <div class="card-body">
                <dl class="row">
                    @if ($page->short)
                        <dt class="col-sm-3">Краткое описание:</dt>
                        <dd class="col-sm-9">
                            {{ $page->short }}
                        </dd>
                    @endif
                    @if ($page->description)
                        <dt class="col-sm-3">Описание:</dt>
                        <dd class="col-sm-9">
                            <div>{!! $page->description !!}</div>
                        </dd>
                    @endif
                    @if ($page->accent)
                        <dt class="col-sm-3">{{ config("site-pages.sitePageAccentName") }}:</dt>
                        <dd class="col-sm-9">
                            <div>{!! $page->accent !!}</div>
                        </dd>
                    @endif
                    @if ($page->comment)
                        <dt class="col-sm-3">{{ config("site-pages.sitePageCommentName") }}:</dt>
                        <dd class="col-sm-9">
                            <div>{!! $page->comment !!}</div>
                        </dd>
                    @endif

                </dl>
            </div>
        </div>
    </div>

    @can("update", $page)
        <div class="modal fade" id="changeFolder" tabindex="-1" role="dialog" aria-labelledby="changeFolderLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changeFolderLabel">Вы уверены?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                        <button type="button"
                                class="btn btn-primary"
                                data-dismiss="modal"
                                data-toggle="collapse"
                                data-target=".collapseChangeFolder"
                                aria-expanded="false"
                                aria-controls="collapseChangeFolder">
                            Понятно
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endcan
@endsection