@include("site-pages::admin.folders.includes.pills")
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\Page::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.folders.pages.index", ["folder" => $folder]) }}"
                           class="nav-link{{ $currentRoute === "admin.folders.pages.index" ? " active" : "" }}">
                            Список
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.folders.pages.tree", ["folder" => $folder]) }}"
                           class="nav-link{{ $currentRoute === "admin.folders.pages.tree" ? " active" : "" }}">
                            Приоритет
                        </a>
                    </li>
                @endcan

                @can("create", \App\Page::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.folders.pages.create", ["folder" => $folder]) }}"
                           class="nav-link{{ $currentRoute === "admin.folders.pages.create" ? " active" : "" }}">
                            Добавить
                        </a>
                    </li>
                @endcan

                @if (! empty($page))
                    @can("view", $page)
                        <li class="nav-item">
                            <a href="{{ route("admin.pages.show", ["page" => $page]) }}"
                               class="nav-link{{ $currentRoute === "admin.pages.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", $page)
                        <li class="nav-item">
                            <a href="{{ route("admin.pages.edit", ["page" => $page]) }}"
                               class="nav-link{{ $currentRoute === "admin.pages.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route("admin.pages.gallery", ["page" => $page]) }}"
                               class="nav-link{{ $currentRoute === "admin.pages.gallery" ? " active" : "" }}">
                                Галерея
                            </a>
                        </li>

                        @includeIf("site-blocks::admin.block-groups.includes.pill",["model" => 'pages', "modelId"=> $page->id, "currentRoute" => $currentRoute ])
                    @endcan



                    @can("viewAny", \App\Meta::class)
                        @can("update", $page)
                            <li class="nav-item">
                                <a href="{{ route("admin.pages.metas", ["page" => $page]) }}"
                                   class="nav-link{{ $currentRoute === "admin.pages.metas" ? " active" : "" }}">
                                    Метатеги
                                </a>
                            </li>
                        @endcan
                    @endcan

                    @can("delete", $page)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-page-{$page->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-page-{$page->id}" }}'">
                                <template v-if="true">
                                    <form action="{{ route('admin.pages.destroy', ['page' => $page]) }}"
                                          id="delete-form-page-{{ $page->id }}"
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