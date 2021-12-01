<?php

use Illuminate\Support\Facades\Route;

Route::group([
        "namespace" => "App\Http\Controllers\Vendor\SitePages\Site",
    "middleware" => ["web"],
"as" => "site.folders.",
"prefix" => config("site-pages.folderRouteName"),
], function () {
Route::get("/", "FolderController@index")
->name("index");
Route::get("/{".config("site-pages.folderRouteName")."}", "FolderController@show")
->name("show");
});