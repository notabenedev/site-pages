<?php

namespace Notabenedev\SitePages\Listeners;

use Notabenedev\SitePages\Events\PageListChange;
use Notabenedev\SitePages\Facades\PageActions;

class FolderPagesIdsClearCache
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PageListChange $event)
    {
        $folder = $event->folder;
        // Очистить список id странциы.
        PageActions::forgetFolderPageIds($folder);
        if (isset($folder->parent))
            event(new PageListChange($folder->parent));
    }
}
