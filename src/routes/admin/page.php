<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SitePages\Admin\PageController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    //folder pages
    Route::resource( "folders.pages" , PageController::class)->shallow();
    //all pages
    Route::get("pages", [PageController::class,"index"])
        ->name("pages.index");
    // Изменить вес у страницы.
//    Route::put("folders/tree/priority", [PageController::class,"changeItemsPriority"])
//        ->name("folders.item-priority");

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
    });

}
);
