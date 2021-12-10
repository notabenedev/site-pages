<?php

namespace Notabenedev\SitePages\Http\Controllers\Site;

use App\Folder;
use App\Http\Controllers\Controller;
use App\Meta;
use Illuminate\Http\Request;
use Notabenedev\SitePages\Facades\FolderActions;

class FolderController extends Controller
{
    public function index(Request $request)
    {
        $folders = Folder::query()
            ->with("image")
            ->whereNull("parent_id")
            ->orderBy("priority")
            ->get();
        $siteBreadcrumb = [
            (object) [
                'active' => true,
                'url' => route("site.folders.index"),
                'title' => config("site-pages.sitePackageName"),
            ]
        ];
        $pageMetas = Meta::getByPageKey("folders");
        return view(
            "site-pages::site.folders.index",
            compact("folders", "siteBreadcrumb", "pageMetas")
        );
    }

    /**
     * Просмотр категории.
     *
     * @param Request $request
     * @param Folder $folder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Folder $folder)
    {
        $collection = $folder
            ->children()
            ->orderBy("priority");
        if (config("site-pages.subFoldersPage")) {
            $collection->with("image");
        }
        $folders = $collection->get();

        $siteBreadcrumb = FolderActions::getSiteBreadcrumb($folder);
        $pageMetas = Meta::getByModelKey($folder);

        if (config("site-pages.subFoldersPage") && $folders->count()) {
            return view(
                "site-pages::site.folders.index",
                compact("folders", "folder", "siteBreadcrumb", "pageMetas")
            );
        }
        else {
            $pages = $folder->pages()->get();

            return view(
                "site-pages::site.folders.show",
                compact("folder", "folders", "pages", "request", "siteBreadcrumb", "pageMetas")
            );
        }
    }
}
