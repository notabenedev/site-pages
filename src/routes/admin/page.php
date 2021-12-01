<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SitePages\Admin\PageController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    //folder pages tree
    Route::get(config("site-pages.foldersUrlName")."/{folder}/".config("site-pages.pagesUrlName")."/tree", [PageController::class, "tree"])
        ->name("folders.pages.tree");

    //folder pages
    //Route::resource( "folders.pages" , PageController::class)->shallow();
    Route::group([
        "prefix" => config("site-pages.foldersUrlName")."/{folder}/".config("site-pages.pagesUrlName"),
        "as" => "folders.pages.",
    ], function (){
        Route::get("", [PageController::class, "index"])->name("index");
        Route::get("/create", [PageController::class, "create"])->name("create");
        Route::post("", [PageController::class, "store"])->name("store");
    });
    Route::group([
        "prefix" => config("site-pages.pagesUrlName")."/{page}",
        "as" => "pages.",
    ], function (){
        Route::get("", [PageController::class, "show"])->name("show");
        Route::get("/edit", [PageController::class, "edit"])->name("edit");
        Route::put("", [PageController::class, "update"])->name("update");
        Route::delete("", [PageController::class, "destroy"])->name("destroy");
    });

    //all pages
    Route::get(config("site-pages.pagesUrlName"), [PageController::class,"index"])
        ->name("pages.index");

    Route::group([
        "prefix" => config("site-pages.pagesUrlName")."/{page}",
        "as" => "pages.",
    ], function () {
        //опубликовать
        Route::put("publish", [PageController::class,"publish"])
            ->name("publish");

        // Meta.
        Route::get("metas", [PageController::class,"metas"])
            ->name("metas");

        // Изменение категории.
        Route::put("change-folder", [PageController::class,"changeFolder"])
            ->name("change-folder");

        // Галерея.
        Route::get("gallery", [PageController::class,"gallery"])
            ->name("gallery");
    });

}
);
