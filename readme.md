#Pages
Install

- Заполнить конфиг необходимыми данными
- php artisan migrate
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
- php artisan make:pages
                        {--all : Run all}
                        {--menu : Config menu}
                        {--models : Export models}
                        {--controllers : Export controllers}
                        {--policies : Export and create rules}
                        {--only-default : Create default rules}
                        {--vue : Export vue components}
##Description
- Категории страниц (папки) и страницы на сайте.
- Категории могут быть вложенными. 
- Страница относится к категории.

##Config
- sitePackageName - название пакета
- siteFoldersName - название структуры категорий (папок)
- sitePagesName - название страниц

- folderNest - вложенность категорий
- folderAdminRoutes - использовать роуты для управления категориями из пакета
- folderSiteRoutes - использовать роуты для категорий на сайте из пакета
- pageAdminRoutes - использовать роуты для управления страницами из пакета
- pageSiteRoutes - использовать роуты для страниц на сайте из пакета

- folderUrlName - url папок на сайте
- foldersUrlName - url папок в админке
- pageUrlName - url страниц на сайте
- pagesUrlName - url страниц в админке

- folderFacade - класс для фасада действий с папками
- pageFacade - класс для фасада действий со страницами
