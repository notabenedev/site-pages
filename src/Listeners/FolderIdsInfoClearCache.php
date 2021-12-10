<?php

namespace Notabenedev\SitePages\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Notabenedev\SitePages\Events\FolderChangePosition;
use Notabenedev\SitePages\Facades\FolderActions;

class FolderIdsInfoClearCache
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
    public function handle(FolderChangePosition $event)
    {
        $folder = $event->folder;
        // Очистить список id категорий.
        FolderActions::forgetFolderChildrenIdsCache($folder);
    }
}
