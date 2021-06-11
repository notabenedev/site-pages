<?php
return [
    "email" => "dev@gis4biz.ru",
    "sitePackageName" => "Категории страниц",
    "siteFoldersName" => "Структура",
    "sitePagesName" => "Страницы",

    "foldersRouteName" => "items",
    "folderRouteName" => "item",
    "pagesRouteName" => "pages",
    "pageRouteName" => "page",

    "folderFacade" => \Notabenedev\SitePages\Helpers\FolderActionsManager::class,

    "folderNest" => 4,

    "folderAdminRoutes" => true,
    "folderSiteRoutes" => true,
];