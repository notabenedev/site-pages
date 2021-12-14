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

            return view(
                "site-pages::site.pages.show",
                compact("page", "siteBreadcrumb", "gallery", "pageMetas", "folder")
            );
        }
        else
            return redirect(route("site.folders.show", ["folder" => $folder]), 301);
    }
}
