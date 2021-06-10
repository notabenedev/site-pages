<?php

namespace Notabenedev\SitePages\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Folder;
use App\Meta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Void_;


class FolderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Folder::class, "folder");
    }

    /**
     * Show Folders List
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    
    public function index (Request $request)
    {
        $view = $request->get("view","default");
        $isTree = $view == "tree";
        if ($isTree) {
            $folders = [];
        }
        else {
            $collection = Folder::query()
                ->whereNull("parent_id")
                ->orderBy("priority","asc");
            $folders = $collection->get();
        }
        return view("site-pages::admin.folders.index", compact("folders", "isTree"));
    }

    /**
     * Add folder form
     *
     * @param Folder|null $folder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function create (Folder $folder = null) {
        return view("site-pages::admin.folders.create", [
            "folder" => $folder,
        ]);
    }

    /**
     * Store data
     *
     * @param Request $request
     * @param Folder|null $folder
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request, Folder $folder = null)
    {
        $this->storeValidator($request->all());
        if (empty($folder)) {
            $item = Folder::create($request->all());
        }
        else {
            $item = $folder->children()->create($request->all());
        }
        /**
         * @var Folder $item
         */
        $item->uploadImage($request, "folders", "image");
        return redirect()
            ->route("admin.folders.show", ["folder" => $item])
            ->with("success", "Добавлено");
    }

    /**
     * Validator
     *
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function storeValidator(array $data)
    {
        Validator::make($data, [
            "title" => ["required", "max:100"],
            "slug" => ["nullable", "max:100", "unique:folders,slug"],
            "image" => ["nullable", "image"],
            "short" => ["nullable", "max:500"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "image" => "Изображение",
            "short" => "Краткое описание",
        ])->validate();
    }

    /**
     *  Display the specified resource.
     *
     * @param Folder $folder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Folder $folder)
    {
        $image = $folder->image;
        $childrenCount = $folder->children->count();
        if ($childrenCount) {
            $children = $folder->children()->orderBy("priority")->get();
        }
        else {
            $children = false;
        }
        return view("site-pages::admin.folders.show", [
            "folder" => $folder,
            "image" => $image,
            "childrenCount" => $childrenCount,
            "children" => $children
        ] );
    }

    /**
     * Edit folder
     *
     * @param Folder $folder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function edit(Folder $folder)
    {
        return view("site-pages::admin.folders.edit", compact("folder"));
    }

    /**
     * Folder update
     *
     * @param Request $request
     * @param Folder $folder
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function update(Request $request, Folder $folder)
    {
        $this->updateValidator($request->all(), $folder);
        $folder->update($request->all());
        $folder->uploadImage($request, "folders", "image");
        return redirect()
            ->route("admin.folders.show", ["folder" => $folder])
            ->with("success", "Успешно обновлено");
    }
    /**
     * Update validate
     *
     * @param array $data
     * @param Folder $folder
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator(array $data, Folder $folder)
    {
        $id = $folder->id;
        Validator::make($data, [
            "title" => ["required", "max:100"],
            "slug" => ["nullable", "max:100", "unique:folders,slug,{$id}"],
            "image" => ["nullable", "image"],
            "short" => ["nullable", "max:500"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "image" => "Изображение",
            "short" => "Краткое описание",
        ])->validate();
    }

    /**
     * Destroy folder
     *
     * @param Folder $folder
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Folder $folder)
    {
        $parent = $folder->parent;
        $children = $folder->children();
        if ($children->count() > 0) {
            return redirect()
                ->route("admin.folders.show", ["folder" => $folder])
                ->with("danger", "Не удалено! Для удаления категории необходимо предварительно удалить дочерние.");
        } else {
            $folder->delete();
            if ($parent) {
                return redirect()
                    ->route("admin.folders.show", ["folder" => $parent])
                    ->with("success", "Успешно удалено");
            }
            else {
                return redirect()
                    ->route("admin.folders.index")
                    ->with("success", "Успешно удалено");
            }
        }

    }

    /**
     * Add metas to folder
     *
     * @param Folder $folder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function metas(Folder $folder)
    {
        $this->authorize("viewAny", Meta::class);
        $this->authorize("update", $folder);

        return view("site-pages::admin.folders.metas", [
            'folder' => $folder,
        ]);
    }

    /**
     * Publish folder
     *
     * @param Folder $folder
     * @return \Illuminate\Http\RedirectResponse
     */

    public function publish(Folder $folder)
    {
        $published =  $folder->published_at;
        $children = $folder->children();
        $collection = $children->get();
        $parentPublished = $folder->isParentPublished();

        // parent folders
        if ($collection->count() > 0) {

            //unpublished parent folder and its children
            if ($published || !$parentPublished) {
                $folder->published_at = null;
                $folder->save();

                foreach ($collection as $child) {
                    $this->publish($child);
                }

            } else {
                //publish this parent folder
                $folder->publish();
            }
            return
             redirect()
                ->back();

        }
        // leaf folders
        else {
            //can't publish the leaf when parent is unpublished
            if (!$published  && !$parentPublished) {
                return redirect()
                    ->back();
            }
            $folder->publish();

            return redirect()
                ->back();
        }

    }
}
