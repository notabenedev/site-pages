<li class="nav-item dropdown folders-menu">
    <a href="#"
       id="folders-menu"
       class="nav-link dropdown-toggle"
       data-bs-toggle="dropdown"
       aria-haspopup="true"
       aria-expanded="false">
        {{ config("site-pages.sitePackageName") }}
    </a>
    <div class="dropdown-menu folders-menu__dropdown"
        aria-labelledby="folders-menu">
        <div class="folders-menu__container">
            @foreach ($foldersTree as $item)
                <ul class="folders-menu__list">
                    @include("site-pages::site.includes.folders-menu-children", ["item" => $item, "first" => true, "level" => 1])
                </ul>
            @endforeach
        </div>
    </div>
</li>