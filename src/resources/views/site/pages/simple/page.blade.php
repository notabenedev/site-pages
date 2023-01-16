<div class="row">
    <div class="col-12 col-md-6 col-lg-8 ">
        <h1 class="h1 page-simple__header">{{ $page->title }}</h1>
    </div>
    <div class="col-12 col-lg-8">
        <div class="description page-simple__description">
            {!! $page->description !!}
        </div>

        @isset($page->accent)
            <div class="page-simple__accent">
                {{ $page->accent }}
            </div>
        @endisset

        @isset($page->comment)
            <div class="description page-simple__description">
                {!! $page->comment !!}
            </div>
        @endisset

        @if( ! empty($page->blockGroups) ? $groups = $page->blockGroups()->orderBy("priority")->get() : false)
            <div class="page-simple__groups">
                @foreach($groups as $group)
                    @includeIf($group->template, ["group" => $group, "blocks" => $group->blocks])
                @endforeach
            </div>
        @endif

    </div>

    <div class="col-12 col-lg-4 order-last order-lg-0">
        @include("site-pages::site.pages.simple.sidebar", ["img" => $page->image, "title" => $page->title, "folder" => $page->folder->title])
    </div>

    <div class="col-12 mt-5">
        @if(config("site-pages.siteSimplePageGalleryHeader", false))
            <h2 class="h2 page-simple__header">{{ config("site-pages.siteSimplePageGalleryHeader") }}</h2>
        @endif
    </div>


@foreach ($gallery as $item)
        @if ($loop->first || ($loop->index +1) % 6 == 0 || ($loop->index +1) % 6 == 1 )
            @php($grid = ["lg-grid-6" => 992, "md-grid-6" => 768, "sm-grid-6" => 576])
            @php($lg = "")
            @else
            @php($grid = ["lg-grid-3" => 992, "md-grid-6" => 768, "sm-grid-6" => 576])
            @php($lg = " col-lg-3")
        @endif
            <div class="col-12 col-sm-6{{ $lg }} mb-4 text-center">
                @img([
                "image" => $item,
                "template" => "pages-grid-sm-12",
                "lightbox" => "lightGroupPage".$page->id,
                "grid" => $grid,
                "imgClass" => "img-fluid rounded",
                ])
            </div>
    @endforeach
    
   
</div>

