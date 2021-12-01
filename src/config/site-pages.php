<?php
return [
    "email" => "dev@gis4biz.ru",
    "sitePackageName" => "Категории страниц",
    "siteFoldersName" => "Структура",
    "sitePagesName" => "Страницы",

    "folderFacade" => \Notabenedev\SitePages\Helpers\FolderActionsManager::class,
    "pageFacade" => \Notabenedev\SitePages\Helpers\PageActionsManager::class,

    "folderNest" => 4,

    "folderAdminRoutes" => true,
    "pageAdminRoutes" => true,

    "folderSiteRoutes" => true,
    "pageSiteRoutes" => true,

    "folderUrlName" => "folder",
    "foldersUrlName" => "directories",
    "pageUrlName" => "service",
    "pagesUrlName" => "services",
];