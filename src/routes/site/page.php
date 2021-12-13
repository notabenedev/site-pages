<?php

use Illuminate\Support\Facades\Route;

Route::group([
    "namespace" => "App\Http\Controllers\Vendor\SitePages\Site",
    "middleware" => ["web"],
    "as" => "site.pages.",
    "prefix" => config("site-pages.pagesUrlName"),
], function () {
    Route::get("/{page}", "PageController@show")
        ->name("show");
});
