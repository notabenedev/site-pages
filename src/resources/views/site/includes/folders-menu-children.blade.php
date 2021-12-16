<li>
    <a href="{{ $item["siteUrl"] }}" class="folders-menu__link{{ $first ? " folders-menu__link_bold" : "" }}">
        {{ $item["title"] }}
    </a>
    @if (! empty($item["children"]))
        <ul class="folders-menu__list folders-menu__list_level-{{ $level }}">
            @foreach ($item["children"] as $child)
                @include("site-pages::site.includes.folders-menu-children", ["item" => $child, "first" => false, "level" => $level + 1])
            @endforeach
        </ul>
    @endif
</li>