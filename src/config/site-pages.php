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

    "pagesLgGrid" => "4",
    "foldersLgGrid" => "4",

    "subFoldersPage" => false,
    "folderPagesPerPage" => 18,

    "showPageModal" => false,
    "siteSimplePage" => false,
    "siteSimplePageSimpleTeaser" => false,
    "siteSimplePageGalleryName" => false,
    "siteSimplePageGalleryHeader" => false,
    "siteSimplePageFormHeader" => "Ответим на вопросы",
    "sitePageAccentName" => "Цена",
    "sitePageCommentName" => "Дополнительная информация",
    "sitePageShowBtnName" => false,
    "sitePageShowFormInputDate" => "Дата",
    "sitePageShowFormInputTitle" => "Номер",
];