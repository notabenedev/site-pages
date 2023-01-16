@extends("layouts.boot")

@section('page-title', "{$page->title} - ")

@section("contents")
    @if (! config("site-pages.siteSimplePage", false))
    <div class="row page-show">
        <div class="col-12">
            <div class="page-show__cover">
                @include("site-pages::site.pages.includes.show-top-section")
                <div class="col-12 page-show__groups">
                    @if( ! empty($page->blockGroups) ? $groups = $page->blockGroups()->orderBy("priority")->get() : false)
                        @foreach($groups as $group)
                            @includeIf($group->template, ["group" => $group, "blocks" => $group->blocks])
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="row page-simple">
            <div class="col-12">
                @include("site-pages::site.pages.simple.page")
            </div>
        </div>
    @endif
@endsection