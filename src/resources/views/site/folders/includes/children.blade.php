<div class="row">
    <div class="col-12">
        <div class="category-children">
            @foreach ($children as $child)
                <div class="category-children__item">
                    <a href="{{ route("site.folders.show", ["folder" => $child]) }}"
                       class="btn btn-sm btn-outline-primary">
                        {{ $child->title }}
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>