<?php

namespace Notabenedev\SitePages\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Page;
use App\Folder;
use App\Meta;
use Illuminate\Support\Facades\Validator;
use Notabenedev\SitePages\Facades\FolderActions;
use Notabenedev\SitePages\Facades\PageActions;

class PageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Page::class, "page");
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Folder $folder = null)
    {
        $collection = Page::query()
            ->with("folder");

        if (! empty($folder)) {
            $collection->where("folder_id", $folder->id);
            $fromRoute = route("admin.folders.pages.index", ["folder" => $folder]);
        }else {
            $fromRoute = route("admin.pages.index");
        }

        if ($title = $request->get("title", false)) {
            $collection->where("title", "like", "%$title%");
        }

        if ($published = $request->get("published", "all")) {
            if ($published == "no") {
                $collection->whereNull("published_at");
            }
            elseif ($published == "yes") {
                $collection->whereNotNull("published_at");
            }
        }

        $collection->orderBy("priority", "asc");
        $pages = $collection->paginate()->appends($request->input());

        return view(
            "site-pages::admin.pages.index",
            compact("folder", "fromRoute", "pages", "request")
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Folder $folder)
    {
        return view(
            "site-pages::admin.pages.create",
            compact("folder")
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Folder $folder)
    {
        $this->storeValidator($request->all());
        $page = $folder->pages()->create($request->all());
        /**
         * @var Page $page
         */
        $page->uploadImage($request, "pages", "image");
        return redirect()
            ->route("admin.pages.show", ["page" => $page])
            ->with("success", "Добавлено");
    }

    protected function storeValidator($data)
    {
        Validator::make($data, [
            "title" => ["required", "max:100", "unique:pages,title"],
            "slug" => ["nullable", "max:150", "unique:pages,slug"],
            "image" => ["nullable", "image"],
            "short" => ["nullable", "max:500"],
            "description" => ["required"],
            "accent" => ["nullable", "max:100"],
            "comment" => ["nullable", "max:500"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "image" => "Изображение",
            "short" => "Краткое описание",
            "description" => "Описание",
            "accent" => "Акцент",
            "comment" => "Комментарий",
        ])->validate();
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        $folder = $page->folder;
        $image = $page->image;
        $folders = FolderActions::getAllList();
        return view(
            "site-pages::admin.pages.show",
            compact("page", "folder", "folders", "image")
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        $folder = $page->folder;

        return view(
            "site-pages::admin.pages.edit",
            compact("page", "folder")
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $this->updateValidator($request->all(), $page);
        // Обновление.
        $page->update($request->all());
        /**
         * @var Page $page
         */
        $page->uploadImage($request, "pages", "image");

        //$page->clearCache();
        return redirect()
            ->route("admin.pages.show", ["page" => $page])
            ->with("success", "Обновлено");
    }
    protected function updateValidator($data, Page $page)
    {
        $id = $page->id;
        Validator::make($data, [
            "title" => ["required", "max:100", "unique:pages,title,{$id}"],
            "slug" => ["nullable", "max:150", "unique:pages,slug,{$id}"],
            "image" => ["nullable", "image"],
            "short" => ["nullable", "max:500"],
            "description" => ["required"],
            "accent" => ["nullable", "max:100"],
            "comment" => ["nullable", "max:500"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "image" => "Изображение",
            "short" => "Краткое описание",
            "description" => "Описание",
            "accent" => "Акцент",
            "comment" => "Комментарий",
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function destroy(Page $page)
    {
        $folder = $page->folder;
        $page->delete();
        return redirect()
            ->route("admin.folders.pages.index", ["folder" => $folder])
            ->with("success", "Удалено");
    }

    /**
     * Metas
     *
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function metas(Page $page)
    {
        $this->authorize("viewAny", Meta::class);
        $this->authorize("update", $page);
        $folder = $page->folder;
        return view("site-pages::admin.pages.metas", compact("folder", "page"));
    }

    /**
     *
     * Publish page
     *
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     */
    public function publish (Page $page)
    {
        $this->authorize("update", $page);
        $published =  $page->published_at;
        $folderPublished = $page->isFolderPublished();

        //can't publish the page when its folder is unpublished
        if (!$published  && !$folderPublished) {
            return redirect()
                ->back()
                ->with("danger","Невозможно опубликовать");
        }
        $page->publish();

        return redirect()
            ->back()
            ->with("success","Статус публикации изменен");

    }

    /**
     * Tree
     *
     * @param Folder $folder
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     */

    public function tree(Folder $folder)
    {
        $this->authorize("update", Page::class);
        $collection = $folder->pages()->orderBy("priority")->get();
        $groups = [];
        foreach ($collection as $item) {
            $groups[] = [
                "name" => $item->title,
                "id" => $item->id,
            ];
        }
        return view ("site-pages::admin.pages.tree", ["groups" => $groups, "folder" => $folder]);
    }

    /**
     * Page Gallery
     *
     * @param Page $page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function gallery(Page $page)
    {
        $this->authorize("update", $page);
        $folder = $page->folder;
        return view("site-pages::admin.pages.gallery", compact("folder", "page"));
    }


    /**
     * Изменить категорию
     *
     * @param Request $request
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function changeFolder(Request $request, Page $page)
    {
        $this->authorize("changeFolder", $page);
        $this->changeFolderValidator($request->all());
        PageActions::changeFolder($page, $request->get("folder_id"));
        return redirect()
            ->route("admin.pages.show", ["page" => $page])
            ->with("success", "Категория изменена");
    }


    protected function changeFolderValidator($data)
    {
        Validator::make($data, [
            "folder_id" => "required|exists:folders,id",
        ], [], [
            "folder_id" => "Категория",
        ])->validate();
    }


}
