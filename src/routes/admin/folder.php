<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SitePages\Admin\FolderController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    //Route::resource( "folders" , FolderController::class);
    Route::group([
        "prefix" => config("site-pages.foldersUrlName"),
        "as" => "folders.",
    ],function (){
        Route::get("", [FolderController::class, "index"])->name("index");
        Route::get("/create", [FolderController::class, "create"])->name("create");
        Route::post("", [FolderController::class, "store"])->name("store");
        Route::get("/{folder}", [FolderController::class, "show"])->name("show");
        Route::get("/{folder}/edit", [FolderController::class, "edit"])->name("edit");
        Route::put("/{folder}", [FolderController::class, "update"])->name("update");
        Route::delete("/{folder}", [FolderController::class, "destroy"])->name("destroy");
    });

    // Изменить вес у категорий.
    Route::put(config("site-pages.foldersUrlName")."/tree/priority", [FolderController::class,"changeItemsPriority"])
        ->name("folders.item-priority");

    Route::group([
        "prefix" => config("site-pages.foldersUrlName")."/{folder}",
        "as" => "folders.",
    ], function () {
        //опубликовать
        Route::put("publish", [FolderController::class,"publish"])
            ->name("publish");

        // Добавить подкатегорию.
        Route::get("create-child", [FolderController::class,"create"])
            ->name("create-child");
        // Сохранить подкатегорию.
        Route::post("store-child", [FolderController::class,"store"])
            ->name("store-child");
        // Meta.
        Route::get("metas", [FolderController::class,"metas"])
            ->name("metas");
    });

}
);
