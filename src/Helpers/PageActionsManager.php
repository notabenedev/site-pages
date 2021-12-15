<?php

namespace Notabenedev\SitePages\Helpers;


use App\Folder;
use App\Meta;
use App\Page;
use Illuminate\Support\Facades\Cache;
use Notabenedev\SitePages\Facades\FolderActions;
use PortedCheese\BaseSettings\Exceptions\PreventActionException;


class PageActionsManager
{
    /**
     * Изменить категорию товара.
     *
     * @param Page $page
     * @param int $folderId
     * @throws PreventActionException
     */
    public function changeFolder(Page $page, int $folderId)
    {
        try {
            $folder = Folder::query()
                ->where("id", $folderId)
                ->firstOrFail();
            $original = $page->folder;
        }
        catch (\Exception $exception) {
            throw new PreventActionException("Категория не найдена");
        }
        $page->folder_id = $folderId;
        $page->save();

        if (! $folder->published_at && $page->published_at) {
            $page->publish();
        }
    }
    /**
     * Получить id страниц категории, либо категории и подкатегорий.
     *
     * @param Folder $folder
     * @param $includeSubs
     * @return mixed
     */
    public function getFolderPageIds(Folder $folder, $includeSubs = false)
    {
        $key = "page-actions-getFolderPageIds:{$folder->id}";
        $key .= $includeSubs ? "-true" : "-false";
        return Cache::rememberForever($key, function() use ($folder, $includeSubs) {
            $query = Page::query()
                ->select("id")
                ->whereNotNull("published_at")
                ->orderBy("priority");
            if ($includeSubs) {
                $query->whereIn("folder_id", FolderActions::getFolderChildren($folder, true));
            }
            else {
                $query->where("folder_id", $folder->id);
            }
            $pages = $query->get();
            $pIds = [];
            foreach ($pages as $page) {
                $pIds[] = $page->id;
            }
            return $pIds;
        });
    }

    /**
     * Очистить кэш идентификаторов товаров.
     *
     * @param Folder $folder
     */
    public function forgetFolderPageIds(Folder $folder)
    {
        $key = "page-actions-getFolderPageIds:{$folder->id}";
        Cache::forget("$key-true");
        Cache::forget("$key-false");
        if (! empty($folder->parent_id)) {
            $this->forgetFolderPageIds($folder->parent);
        }
    }

    public function getPageById($id){
        return Page::find($id);
    }

    public function getPageGallery(Page $page){
        return $page->images()->orderBy("weight")->get();
    }

    public function getPageMeta(Page $page){
        return Meta::getByModelKey($page);
    }
}