@extends("layouts.boot")

@section('page-title', "{$page->title} - ")

@section("contents")
    @if (! config("site-pages.siteSimplePage", false))
    <div class="row page-show">
        <div class="col-12">
            <div class="page-show__cover">
                @include("site-pages::site.pages.includes.show-top-section")
                <div class="col-12 page-show__groups">
                    @if( ! empty($page->blockGroups) ? $groups = $page->blockGroupsNotInTemplates(["site-blocks::site.block-groups.templates.tab"])->get() : false)
                        @foreach($groups as $group)
                            @includeIf($group->template, ["group" => $group, "blocks" => $group->getBlocksCache()])
                        @endforeach
                    @endif
                    @if( ! empty($page->blockGroups) ? $groups = $page->blockGroupsByTemplate("site-blocks::site.block-groups.templates.tab")->get() : false)
                         @includeIf("site-blocks::site.block-groups.templates.tab-pills", ["groups" => $groups])
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