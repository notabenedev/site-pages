<?php

namespace Notabenedev\SitePages\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Folder;
use App\Meta;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Notabenedev\SitePages\Facades\FolderActions;
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
            $folders = FolderActions::getTree();
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
            "description" => ["nullable"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "image" => "Изображение",
            "short" => "Краткое описание",
            "description" => "Описание",
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
            "description" => ["nullable"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "image" => "Изображение",
            "short" => "Краткое описание",
            "description" => "Описание",
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     */

    public function publish(Folder $folder)
    {
        $this->authorize("update", $folder);

        if ($folder->publishCascade())
            return
                redirect()
                    ->back()
                    ->with("success", "Успешно изменено");
        else
            return
                redirect()
                    ->back()
                    ->with("danger",  "Статус не может быть изменен");
    }
    /**
     * Изменить приоритет
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeItemsPriority(Request $request)
    {
        $data = $request->get("items", false);
        if ($data) {
            $result = FolderActions::saveOrder($data);
            if ($result) {
                return response()
                    ->json("Порядок сохранен");
            }
            else {
                return response()
                    ->json("Ошибка, что то пошло не так");
            }
        }
        else {
            return response()
                ->json("Ошибка, недостаточно данных");
        }
    }
}
