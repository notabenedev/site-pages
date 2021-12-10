<?php

namespace Notabenedev\SitePages\Observers;

use App\Folder;
use Notabenedev\SitePages\Events\FolderChangePosition;
use Notabenedev\SitePages\Facades\FolderActions;
use PortedCheese\BaseSettings\Exceptions\PreventDeleteException;

class FolderObserver
{


    /**
     * После создания.
     *
     * @param Folder $folder
     */
    public function created(Folder $folder)
    {
        event(new FolderChangePosition($folder));
    }

    /**
     * После обновления.
     *
     * @param Folder $folder
     */
    public function updating(Folder $folder)
    {
        $original = $folder->getOriginal();
        if (isset($original["parent_id"]) && $original["parent_id"] != $folder->parent_id) {
            $this->folderChangedParent($folder, $original["parent_id"]);
        }
    }

    /**
     * Очистить список id дочерних категорий.
     *
     * @param Folder $folder
     * @param $parent
     */
    protected function folderChangedParent(Folder $folder, $parent)
    {
        if (! empty($parent)) {
            $parent = Folder::find($parent);
            event(new FolderChangePosition($parent));
        }
        event(new FolderChangePosition($folder));
    }

}
