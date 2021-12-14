<?php

namespace Notabenedev\SitePages\Observers;

use App\Folder;
use Notabenedev\SitePages\Events\FolderChangePosition;
use Notabenedev\SitePages\Facades\FolderActions;
use PortedCheese\BaseSettings\Exceptions\PreventActionException;
use PortedCheese\BaseSettings\Exceptions\PreventDeleteException;

class FolderObserver
{

    /**
     * Перед сохранением
     *
     * @param Folder $folder
     */
    public function creating(Folder $folder){
        $max = Folder::query()
            ->where("parent_id", $folder->parent_id)
            ->max("priority");
        $folder->priority = $max +1;
        if ($folder->isParentPublished())  $folder->published_at = now();

    }

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
     * Перед обновлением.
     *
     * @param Folder $folder
     * @throws PreventActionException
     */
    public function updating(Folder $folder)
    {
        $original = $folder->getOriginal();
        if (isset($original["parent_id"]) && $original["parent_id"] != $folder->parent_id) {

            if ((! $folder->parent->published_at) && $folder->published_at) {
               //$folder->publishCascade();
                throw new PreventActionException("Невозможно изменить категорию, родитель не опубликован");
            }

            $this->folderChangedParent($folder, $original["parent_id"]);

        }
    }

    /**
     * Перед удалением
     *
     * @param Folder $folder
     * @throws PreventDeleteException
     */
    public function deleting(Folder $folder){
        if ($folder->children->count()){
            throw new PreventDeleteException("Невозможно удалить категорию, у нее есть подкатегории");
        }
        if ($folder->pages->count()){
            throw new PreventDeleteException("Невозможно удалить категорию, у нее есть элементы");
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
