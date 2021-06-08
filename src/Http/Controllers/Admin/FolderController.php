<?php

namespace Notabenedev\SitePages\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Folder;
use App\Meta;


class FolderController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Folder::class, "folder");
    }
    
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
}
