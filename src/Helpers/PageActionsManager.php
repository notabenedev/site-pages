<?php

namespace Notabenedev\SitePages\Helpers;


use App\Folder;
use App\Page;
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
}