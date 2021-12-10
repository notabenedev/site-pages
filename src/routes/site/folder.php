<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "namespace" => "App\Http\Controllers\Vendor\SitePages\Site",
    "middleware" => ["web"],
    "as" => "site.folders.",
    "prefix" => config("site-pages.foldersUrlName"),
], function () {
    Route::get("/", "FolderController@index")->name("index");
    Route::get("/{folder}", "FolderController@show")->name("show");
});