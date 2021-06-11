@can("update", \App\Folder::class)
    <admin-folder-list :structure="{{ json_encode($folders) }}"
                         :nesting="{{ config("site-pages.folderNest") }}"
                         :update-url="'{{ route("admin.folders.item-priority") }}'">
    </admin-folder-list>
@else
    <ul>
        @foreach ($folders as $folder)
            <li>
                @can("view", \App\Folder::class)
                    <a href="{{ route('admin.folders.show', ['folder' => $folder["slug"]]) }}"
                       class="btn btn-link">
                        {{ $folder["title"] }}
                    </a>
                @else
                    <span>{{ $folder['title'] }}</span>
                @endcan
                <span class="badge badge-secondary">{{ count($folder["children"]) }}</span>
                @if (count($folder["children"]))
                    @include("site-pages::admin.folders.includes.tree", ['folders' => $folder["children"]])
                @endif
            </li>
        @endforeach
    </ul>
@endcan
