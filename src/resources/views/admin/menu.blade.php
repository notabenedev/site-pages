@php
    $active = (strstr($currentRoute, ".folders.") !== false) ||
              (strstr($currentRoute, ".pages.") !== false);
@endphp

@if ($theme == "sb-admin")
    <li class="nav-item {{ $active ? " active" : "" }}">
        <a href="#"
           class="nav-link"
           data-bs-toggle="collapse"
           data-bs-target="#collapse-folders-menu"
           aria-controls="#collapse-folders-menu"
           aria-expanded="{{ $active ? "true" : "false" }}">
            <i class="fas fa-stream"></i>
            <span>{{ config("site-pages.sitePackageName") }}</span>
        </a>

        <div id="collapse-folders-menu"
             class="collapse"
             data-bs-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @can("viewAny", \App\Folder::class)
                    <a href="{{ route("admin.folders.index") }}"
                       class="collapse-item{{ strstr($currentRoute, ".folders.") !== false ? " active" : "" }}">
                        <span>{{ config("site-pages.siteFoldersName") }}</span>
                    </a>
                @endcan
                    @can("viewAny", \App\Page::class)
                        <a href="{{ route("admin.pages.index") }}"
                           class="collapse-item{{ strstr($currentRoute, ".pages.") !== false ? " active" : "" }}">
                            <span>{{ config("site-pages.sitePagesName") }}</span>
                        </a>
                    @endcan
            </div>
        </div>
    </li>
@else
    <li class="nav-item dropdown">
        <a href="#"
           class="nav-link dropdown-toggle{{ $active ? " active" : "" }}"
           role="button"
           id="folders-menu"
           data-bs-toggle="dropdown"
           aria-haspopup="true"
           aria-expanded="false">
            <i class="fas fa-stream"></i>
            {{ config("site-pages.sitePackageName") }}
        </a>

        <div class="dropdown-menu" aria-labelledby="folders-menu">
            @can("viewAny", \App\Folder::class)
                <a href="{{ route("admin.folders.index") }}"
                   class="dropdown-item">
                    {{ config("site-pages.siteFoldersName") }}
                </a>
            @endcan
                @can("viewAny", \App\Page::class)
                    <a href="{{ route("admin.pages.index") }}"
                       class="collapse-item{{ strstr($currentRoute, ".pages.") !== false ? " active" : "" }}">
                        <span>{{ config("site-pages.sitePagesName") }}</span>
                    </a>
                @endcan

        </div>
    </li>
@endif
