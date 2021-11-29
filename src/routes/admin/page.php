<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SitePages\Admin\PageController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    //folder pages tree
    Route::get("folders/{folder}/pages/tree", [PageController::class, "tree"])
        ->name("folders.pages.tree");
    //folder pages
    Route::resource( "folders.pages" , PageController::class)->shallow();
    //all pages
    Route::get("pages", [PageController::class,"index"])
        ->name("pages.index");

    Route::group([
        "prefix" => "pages/{page}",
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
