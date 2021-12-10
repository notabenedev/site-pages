<div class="card folder-teaser h-100">
    <a href="{{ route("site.folders.show", ["folder" => $folder]) }}"
       class="folder-image">
        @if ($folder->image)
            @pic([
            "image" => $folder->image,
            "template" => "pages-grid-sm-12",
            "grid" => $grid,
            "imgClass" => "card-img-top",
            ])
        @else
            <div class="folder-image__empty">
                <svg class="folder-image__empty-ico">
                    <use xlink:href="#folder-image-empty"></use>
                </svg>
            </div>
        @endif
    </a>
    <div class="card-body folder-teaser__body">
        <a class="folder-teaser__title"
           href="{{ route("site.folders.show", ["folder" => $folder]) }}">
            {{ $folder->title }}
        </a>
        @if (! empty($folder->short))
           <p class="text-secondary">
            {{ $folder->short }}
           </p>
        @endif
    </div>
</div>