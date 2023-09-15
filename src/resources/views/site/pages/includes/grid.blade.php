<div id="page-grid" class="row pages-grid">
    @if ($pages->count())
        @foreach ($pages as $item)
            <div class="{{ $col }} pages-grid-col">
                @include("site-pages::site.pages.includes.teaser", ["page" => $item->getTeaserData(), "grid" => $grid])
            </div>
        @endforeach
    @endif
</div>