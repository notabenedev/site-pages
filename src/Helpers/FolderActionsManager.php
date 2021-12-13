<?php

namespace Notabenedev\SitePages\Helpers;

use App\Folder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class FolderActionsManager
{

    /**
     * Список всех категорий.
     *
     * @return array
     */
    public function getAllList()
    {
        $folders = [];
        foreach (Folder::all()->sortBy("title") as $item) {
            $folders[$item->id] = "$item->title ({$item->slug})";
        }
        return $folders;
    }

    /**
     * Получить дерево категорий.
     * 
     * @param bool $forJs
     * @return array
     */
    public function getTree()
    {
        list($tree, $noParent) = $this->makeTreeDataWithNoParent();
        $this->addChildren($tree);
        $this->clearTree($tree, $noParent);
        return $this->sortByPriority($tree);
    }

    /**
     * Сохранить порядок.
     *
     * @param array $data
     * @return bool
     */
    public function saveOrder(array $data)
    {
        try {
            $this->setItemsWeight($data, 0);
        }
        catch (\Exception $exception) {
            return false;
        }
        return true;
    }


    /**
     * Сохранить порядок.
     *
     * @param array $items
     * @param int $parent
     */
    protected function setItemsWeight(array $items, int $parent)
    {
        foreach ($items as $priority => $item) {
            $id = $item["id"];
            if (! empty($item["children"])) {
                $this->setItemsWeight($item["children"], $id);
            }
            $parentId = ! empty($parent) ? $parent : null;
            // Обновление Категории.
            $folder = Folder::query()
                ->where("id", $id)
                ->first();
            $folder->priority = $priority;
            $folder->parent_id = $parentId;
            $folder->save();
        }
    }

    /**
     * Сортировка результата.
     *
     * @param $tree
     * @return array
     */
    protected function sortByPriority($tree)
    {
        $sorted = array_values(Arr::sort($tree, function ($value) {
            return $value["priority"];
        }));
        foreach ($sorted as &$item) {
            if (! empty($item["children"])) {
                $item["children"] = self::sortByPriority($item["children"]);
            }
        }
        return $sorted;
    }

    /**
     * Очистить дерево от дочерних.
     *
     * @param $tree
     * @param $noParent
     */
    protected function clearTree(&$tree, $noParent)
    {
        foreach ($noParent as $id) {
            $this->removeChildren($tree, $id);
        }
    }

    /**
     * Убрать подкатегории.
     *
     * @param $tree
     * @param $id
     */
    protected function removeChildren(&$tree, $id)
    {
        if (empty($tree[$id])) {
            return;
        }
        $item = $tree[$id];
        foreach ($item["children"] as $key => $child) {
            $this->removeChildren($tree, $key);
            if (! empty($tree[$key])) {
                unset($tree[$key]);
            }
        }
    }

    /**
     * Добавить дочернии элементы.
     *
     * @param $tree
     */
    protected function addChildren(&$tree)
    {
        foreach ($tree as $id => $item) {
            if (empty($item["parent"])) {
                continue;
            }
            $this->addChild($tree, $item, $id);
        }
    }

    /**
     * Добавить дочерний элемент.
     *
     * @param $tree
     * @param $item
     * @param $id
     * @param bool $children
     */
    protected function addChild(&$tree, $item, $id, $children = false)
    {
        // Добавление к дочерним.
        if (! $children) {
            $tree[$item["parent"]]["children"][$id] = $item;
        }
        // Обновление дочерних.
        else {
            $tree[$item["parent"]]["children"][$id]["children"] = $children;
        }

        $parent = $tree[$item["parent"]];
        if (! empty($parent["parent"])) {
            $items = $parent["children"];
            $this->addChild($tree, $parent, $parent["id"], $items);
        }
    }

    /**
     * Получить данные по категориям.
     *
     * @return array
     */
    protected function makeTreeDataWithNoParent()
    {
        $folders = DB::table("folders")
            ->select("id", "title", "slug", "parent_id", "priority")
            ->orderBy("parent_id")
            ->get();

        $tree = [];
        $noParent = [];
        foreach ($folders as $folder) {
            $tree[$folder->id] = [
                "title" => $folder->title,
                'slug' => $folder->slug,
                'parent' => $folder->parent_id,
                "priority" => $folder->priority,
                "id" => $folder->id,
                'children' => [],
                "url" => route("admin.folders.show", ['folder' => $folder->slug]),
            ];
            if (empty($folder->parent_id)) {
                $noParent[] = $folder->id;
            }
        }
        return [$tree, $noParent];
    }

    /**
     * Admin breadcrumbs
     *
     * @param Folder $folder
     * @param bool $isPagePage
     * @return array
     *
     */
    public function getAdminBreadcrumb(Folder $folder, $isPagePage = false)
    {
        $breadcrumb = [];
        if (! empty($folder->parent)) {
            $breadcrumb = $this->getAdminBreadcrumb($folder->parent);
        }
        else {
            $breadcrumb[] = (object) [
                "title" => config("site-pages.sitePackageName"),
                "url" => route("admin.folders.index"),
                "active" => false,
            ];
        }
        $routeParams = Route::current()->parameters();
        $isPagePage = $isPagePage && ! empty($routeParams["page"]);
        $active = ! empty($routeParams["folder"]) &&
            $routeParams["folder"]->id == $folder->id &&
            ! $isPagePage;
        $breadcrumb[] = (object) [
            "title" => $folder->title,
            "url" => route("admin.folders.show", ["folder" => $folder]),
            "active" => $active,
        ];
        if ($isPagePage) {
            $page = $routeParams["page"];
            $breadcrumb[] = (object) [
                "title" => $page->title,
                "url" => route("admin.pages.show", ["page" => $page]),
                "active" => true,
            ];
        }
        return $breadcrumb;
    }
    /**
     * Хлебные крошки для сайта.
     *
     * @param Folder $folder
     * @param bool $isPage
     * @param bool $parent
     * @return array
     */
    public function getSiteBreadcrumb(Folder $folder, $isPage = false, $parent = false)
    {
        $breadcrumb = [];
        if (! empty($folder->parent_id)) {
            $breadcrumb = $this->getSiteBreadcrumb($folder->parent, false, true);
        }
        else {
            $breadcrumb[] = (object) [
                "title" => config("site-pages.sitePackageName"),
                "url" => route("site.folders.index"),
                "active" => false,
            ];
        }

        $breadcrumb[] = (object) [
            "title" => $folder->title,
            "url" => route("site.folders.show", ["folder" => $folder]),
            "active" => false,
        ];

        if ($isPage) {
            $routeParams = Route::current()->parameters();
            $page = $routeParams["page"];
            $breadcrumb[] = (object) [
                "title" => $page->title,
                "url" => route("site.pages.show", ["page" => $page]),
                "active" => true,
            ];
        }
        elseif (! $parent) {
            $length = count($breadcrumb);
            $breadcrumb[$length - 1]->active = true;
        }

        return $breadcrumb;
    }

    /**
     * Получить id всех подкатегорий.
     *
     * @param Folder $folder
     * @param bool $includeSelf
     * @return array
     */
    public function getFolderChildren(Folder $folder, $includeSelf = false)
    {
        $key = "folder-actions-getFolderChildren:{$folder->id}";
        $children = Cache::rememberForever($key, function () use ($folder) {
            $children = [];
            $collection = Folder::query()
                ->select("id")
                ->where("parent_id", $folder->id)
                ->get();
            foreach ($collection as $child) {
                $children[] = $child->id;
                $folders = $this->getFolderChildren($child);
                if (! empty($folders)) {
                    foreach ($folders as $id) {
                        $children[] = $id;
                    }
                }
            }
            return $children;
        });
        if ($includeSelf) {
            $children[] = $folder->id;
        }
        return $children;
    }

    /**
     * Очистить кэш списка id категорий.
     *
     * @param Folder $folder
     */
    public function forgetFolderChildrenIdsCache(Folder $folder)
    {
        Cache::forget("folder-actions-getFolderChildren:{$folder->id}");
        $parent = $folder->parent;
        if (! empty($parent)) {
            $this->forgetFolderChildrenIdsCache($parent);
        }
    }
}