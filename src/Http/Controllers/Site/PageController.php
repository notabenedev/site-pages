<?php

namespace Notabenedev\SitePages\Http\Controllers\Site;

use App\Folder;
use App\Page;
use App\Http\Controllers\Controller;
use App\Meta;
use Illuminate\Http\Request;
use Notabenedev\SitePages\Facades\FolderActions;

class PageController extends Controller
{
    /**
     * Просмотр Страницы.
     *
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Page $page)
    {
        $folder = $page->folder;
        if ($page->published_at) {

            $gallery = $page->images()->orderBy("weight")->get();
            $siteBreadcrumb = FolderActions::getSiteBreadcrumb($folder, true);
            $pageMetas = Meta::getByModelKey($page);

            if (!empty($page->blockGroups)){
                if (empty($groups = $page->blockGroupsNotInTemplates(["site-blocks::site.block-groups.templates.tab"])))
                    $groups = null;
                if (empty($tabs = $page->blockGroupsByTemplates(["site-blocks::site.block-groups.templates.tab"])))
                    $tabs = null;
            }
            return view(
                "site-pages::site.pages.show",
                config("site-pages.siteBreadcrumbs", false)?
                    compact("page", "siteBreadcrumb", "gallery", "pageMetas", "folder","groups","tabs"):
                    compact("page", "gallery", "pageMetas", "folder", "groups", "tabs")
            );
        }
        else
            return redirect(route("site.folders.show", ["folder" => $folder]), 301);
    }
}
