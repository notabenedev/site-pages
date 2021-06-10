@can("update", \App\Category::class)
    <admin-category-list :structure="{{ json_encode($categories) }}"
                         :nesting="{{ config("category-product.categoryNest") }}"
                         :update-url="'{{ route("admin.categories.item-priority") }}'">
    </admin-category-list>
@else
    <ul>
        @foreach ($categories as $category)
            <li>
                @can("view", \App\Category::class)
                    <a href="{{ route('admin.categories.show', ['category' => $category["slug"]]) }}"
                       class="btn btn-link">
                        {{ $category["title"] }}
                    </a>
                @else
                    <span>{{ $category['title'] }}</span>
                @endcan
                <span class="badge badge-secondary">{{ count($category["children"]) }}</span>
                @if (count($category["children"]))
                    @include("category-product::admin.categories.includes.tree", ['categories' => $category["children"]])
                @endif
            </li>
        @endforeach
    </ul>
@endcan