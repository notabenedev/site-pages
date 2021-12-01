@if (! empty($folder))
    @include("site-pages::admin.folders.includes.breadcrumb")
@endif
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\Folder::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.folders.index") }}"
                           class="nav-link{{ isset($isTree) && !$isTree ? " active" : "" }}">
                            {{ config("site-pages.sitePackageName") }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.folders.index') }}?view=tree"
                           class="nav-link{{ isset($isTree) && $isTree ? " active" : "" }}">
                            {{ config("site-pages.siteFoldersName") }}
                        </a>
                    </li>
                @endcan

                @empty($folder)
                    @can("create", \App\Folder::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.folders.create") }}"
                               class="nav-link{{ $currentRoute === "admin.folders.create" ? " active" : "" }}">
                                Добавить
                            </a>
                        </li>
                    @endcan
                @else
                    @can("create", \App\Folder::class)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ $currentRoute == 'admin.folders.create-child' ? " active" : "" }}"
                               data-toggle="dropdown"
                               href="#"
                               role="button"
                               aria-haspopup="true"
                               aria-expanded="false">
                                Добавить
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="{{ route('admin.folders.create') }}">
                                    Основную
                                </a>
                                @if ($folder->nesting < config("site-pages.folderNest"))
                                    <a class="dropdown-item"
                                       href="{{ route('admin.folders.create-child', ['folder' => $folder]) }}">
                                        Подкатегорию
                                    </a>
                                @endif
                            </div>
                        </li>
                    @endcan

                    @can("view", $folder)
                        <li class="nav-item">
                            <a href="{{ route("admin.folders.show", ["folder" => $folder]) }}"
                               class="nav-link{{ $currentRoute === "admin.folders.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", $folder)
                        <li class="nav-item">
                            <a href="{{ route("admin.folders.edit", ["folder" => $folder]) }}"
                               class="nav-link{{ $currentRoute === "admin.folders.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan

                    @can("viewAny", \App\Meta::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.folders.metas", ["folder" => $folder]) }}"
                               class="nav-link{{ $currentRoute === "admin.folders.metas" ? " active" : "" }}">
                                Метатеги
                            </a>
                        </li>
                    @endcan

                    @can("viewAny", \App\Page::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.folders.pages.index", ["folder" => $folder]) }}"
                               class="nav-link{{ strstr($currentRoute, "pages.") !== false ? " active" : "" }}">
                                {{ config("site-pages.sitePagesName") }}
                            </a>
                        </li>
                    @endcan

                    @can("delete", $folder)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-folder-{$folder->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-folder-{$folder->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.folders.destroy', ['folder' => $folder]) }}"
                                          id="delete-form-folder-{{ $folder->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("delete")
                                    </form>
                                </template>
                            </confirm-form>
                        </li>
                    @endcan
                @endif
            </ul>
        </div>
    </div>
</div>