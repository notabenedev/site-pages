<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SitePages\Admin\FolderController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    Route::resource( config("site-pages.FoldersRouteName") , FolderController::class);


}

);
