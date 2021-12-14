<?php

namespace Notabenedev\SitePages\Http\Controllers\Site;

use App\Folder;
use App\Page;
use App\Http\Controllers\Controller;
use App\Meta;
use Illuminate\Http\Request;
use Notabenedev\SitePages\Facades\FolderActions;
use Notabenedev\SitePages\Facades\PageActions;

class FolderController extends Controller
{
    public function index(Request $request)
    {
        $folders = Folder::query()
            ->with("image")
            ->whereNull("parent_id")
            ->whereNotNull('published_at')
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
        if ($folder->published_at){
            $collection = $folder
                ->children()
                ->whereNotNull("published_at")
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
                $pageIds = PageActions::getFolderPageIds($folder, true);
                $pages = Page::query()->whereIn("id", $pageIds)->orderBy("priority")->get();
                return view(
                    "site-pages::site.folders.show",
                    compact("folder", "folders", "pages", "request", "siteBreadcrumb", "pageMetas")
                );
            }
        }
        else
            return redirect(route("site.folders.index"), 301);

    }
}
