<?php
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Vendor\SitePages\Admin\FolderController;

//Route::get('admin/folders', [FolderController::class, 'index'])->middleware("web","management");
//Route::middleware(["web","management"])
//    ->namespace("App\Http\Controllers\Vendor\SitePages\Admin")
//    ->prefix("admin.")
//    ->as("admin.")
//    ->get('/folders', [FolderController::class, 'index']);

//Route::group([
//    "namespace" => "App\Http\Controllers\Vendor\SitePages\Admin",
//    "middleware" => ["web", "management"],
//    "as" => "admin.",
//    "prefix" => "admin",
//        ], function (){
//
//    Route::get('/folders',
//        [FolderController::class, 'index']
//    );
//    }
//);
Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    //Route::get('/folders', [FolderController::class, 'index']);
    Route::resource("folders", FolderController::class);


}

);
