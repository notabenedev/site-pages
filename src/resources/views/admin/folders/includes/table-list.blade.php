<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Заголовок</th>
            <th>Адресная строка</th>
            <th>Дочерние</th>
            @canany(["edit", "view", "delete"], \App\Folder::class)
                <th>Действия</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        @foreach ($folders as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->slug }}</td>
                <td>{{ $item->children->count() }}</td>
                @canany(["edit", "view", "delete"], \App\Folder::class)
                    <td>
                        <div role="toolbar" class="btn-toolbar">
                            <div class="btn-group mr-1">
                                @can("update", \App\Folder::class)
                                    <a href="{{ route("admin.folders.edit", ["folder" => $item]) }}" class="btn btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can("view", \App\Folder::class)
                                    <a href="{{ route('admin.folders.show', ['folder' => $item]) }}" class="btn btn-dark">
                                        <i class="far fa-eye"></i>
                                    </a>
                                @endcan
                                @can("delete", \App\Folder::class)
                                    <button type="button" class="btn btn-danger" data-confirm="{{ "delete-form-{$item->id}" }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endcan
                            </div>
                            @can("update", \App\Folder::class)
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-{{ $item->published_at ? "success" : "secondary" }}" data-confirm="{{ "publish-form-{$item->id}" }}">
                                        <i class="fas fa-toggle-{{ $item->published_at ? "on" : "off" }}"></i>
                                    </button>
                                </div>
                            @endcan
                        </div>
                        @can("update", \App\Folder::class)
                            <confirm-form :id="'{{ "publish-form-{$item->id}" }}'" text="Это изменит статус отображения на сайте! Невозможно снять с публикации родителя, если опубликованы дочерние элементы и страницы. Невозможно опубликовать дочерний элемент, если не опубликован его родитель. " confirm-text="Да, изменить!">
                                <template v-if="true">
                                    <form action="{{ route('admin.folders.publish', ['folder' => $item]) }}"
                                          id="publish-form-{{ $item->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("put")
                                    </form>
                                </template>
                            </confirm-form>
                        @endcan
                        @can("delete", \App\Folder::class)
                            <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                <template v-if="true">
                                    <form action="{{ route('admin.folders.destroy', ['folder' => $item]) }}"
                                          id="delete-form-{{ $item->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                </template>
                            </confirm-form>
                        @endcan
                    </td>
                @endcanany
            </tr>
        @endforeach
        <tr class="text-center">
            @canany(["edit", "view", "delete"], \App\Folder::class)
                <td colspan="4">
            @else
                <td colspan="3">
            @endcanany

                </td>
        </tr>
        </tbody>
    </table>
</div>