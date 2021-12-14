<?php

namespace Notabenedev\SitePages\Observers;

use App\Page;
use Notabenedev\SitePages\Facades\FolderActions;
use Notabenedev\SitePages\Facades\PageActions;

class PageObserver
{
    /**
     * Перед сохранением
     *
     */
    public function creating(Page $page){
        if ($page->isFolderPublished()) $page->published_at = now();
    }
    /**
     * Перед обновлением
     *
     */
    public function updating(Page $page){
        if (! $page->isFolderPublished()) $page->published_at = null;
    }

    /**
     * После обновления.
     *
     * @param Page $page
     */
    public function updated(Page $page)
    {
        $page->clearCache();
        PageActions::forgetFolderPageIds($page->folder);
    }

    /**
     * После удаления.
     *
     * @param Page $page
     */
    public function deleted(Page $page)
    {
        // Очистить кэш.
        $page->clearCache();
    }

}
