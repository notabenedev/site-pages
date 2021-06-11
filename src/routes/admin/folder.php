<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SitePages\Admin\FolderController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    Route::resource( "folders" , FolderController::class);

    // Изменить вес у категорий.
    Route::put("folders/tree/priority", [FolderController::class,"changeItemsPriority"])
        ->name("folders.item-priority");

    Route::group([
        "prefix" => "folders/{folder}",
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
