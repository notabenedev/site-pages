## Конфиг
    php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=config

## Install
    php artisan migrate
    php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
    php artisan make:pages
                        {--all : Run all}
                        {--menu : Config menu}
                        {--models : Export models}
                        {--controllers : Export controllers}
                        {--observers : Export observers}
                        {--policies : Export and create rules}
                        {--only-default : Create default rules}
                        {--vue : Export vue components}
                        {--js : Export scripts}
                        {--scss: Export scss}
    
    if IE 11 support:
                npm install flickity@2.2.2  
                npm install flickity-as-nav-for@2.0.1
    not support IE:
                npm install flickity 
                npm install flickity-as-nav-for
    npm run dev

    
##Формы:
    page-order-form: name*, phone*, (date*), (title*, folder*), message
    page-question-form: name*, phone*, (title*), message
    
    
##Description
- Категории страниц (папки) и страницы на сайте.
- Категории могут быть вложенными. 
- Страница относится к категории.

##Config

Шаблон для меню:

    site-pages::site.includes.folders-menu

Выгрузка конфигурации:
    
    php artisan vendor:publish --provider="PortedCheese\CategoryProduct\ServiceProvider" --tag=config
   
Переменные:
    
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

- subFolderPage - включить страницу подкатегорий (true,false)

- pagesLgGrid - оторбражение сетки страниц (4,6)
- foldersLgGrid - отображение сетки категорий (4,6)
- folderPagesPerPage - категорий на странице

- showPageModal - модальное окно страницы (false)
- sitePageAccentName - название поля Accent
- sitePageCommentName - название поля Comment
- sitePageShowBtnName - название кнопки
- sitePageShowFormInputDate - заголовок поля формы
- sitePageShowFormInputTitle" - заголовок поля формы

## v3.1.5
Обновлены шаблоны вывода групп блоков типа Табы  (tabs)
Проверить переопределение:
- site.pages.show, site.pages.includes.show-top-section, site.pages.simple.page
## v3.1.4
Обновлены шаблоны вывода страниц  (не показывает стороку блоков или галареи, если нет элементов)
site-pages::site.pages.show site-pages::site.pages.simple.page  site-pages::site.pages.includes.show-top-section
## v3.1.3
Обновлено управление параметрами конфига: "pagesLgGrid", "foldersLgGrid"
## v3.1.2
Добавлено описание к категории
- php artisan migrate
## v3.1.1
Fix изменения категории для страницы (добавлен слушатель)
## v3.1.0
Разделен вывод блоков-табов на странице (если блоки подключены)
- внесите изменения в шаблон site-pages::site.pages.show, если он переопределен
- внесите изменения в шаблон site-pages::site.pages.simple.page, если он переопределен
  Добавлен вывод блоков в модальное окно страницы
- внесите изменения в шаблон site-pages::site.pages.includes.show-top-section, если он переопределен
## v3.0.6
alter table folders.short: tinyText => text
- php artisan migrate
## v3.0.5
config: add "siteBreadcrumbs" => true | false, fix config merge
## v3.0.4
fix simple view without blocks
## v3.0.3
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
## v3.0.1
Support IE 11:
- npm uninstall jquery-bridget
- npm uninstall flickity
- npm uninstall flickity-as-nav-for
- npm install flickity@2.2.2
- npm install flickity-as-nav-for@2.0.1
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
- npm run

## v2.0.1
Support site-blocks package to pages
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force

## v1.2.8
- Config: use siteSimpleGalleryHeader
- Fix PulishCascade to Admin/FolderController

## v1.2.7
Make command: add observers
- php artisan make:pages --observers

## v1.2.4-1.2.6
Change simple blade, image filters
- php artisan config:clear
- php artisan cache:clear

## v1.2.1 - v1.2.3
Change css
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
- npm run

## v1.2.0
add simple page, simple teaser (не для модальных страниц)

New config parameters:
- "siteSimplePage" => false,
- "siteSimplePageSimpleTeaser" => false,
- "siteSimplePageGalleryHeader" => "Наши работы",
- "siteSimplePageFormHeader" => "Ответим на вопросы",

Update:
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=config  -выгрузит новый конфиг
- npm run

## v1.1.0
fix xs-view modal carousel:
- npm install jquery-bridget
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force

## v1.1.2
pages.comment - вывод в html:

Изменен тип поля БД pages.comment на text.
В админ панели добавлен tiny-редактор к полю комментария.
В шаблоне выводится поле comment как html.

Обновление:
- php artisan migrate.
- Если изменен шаблон вывода Page на сайте - обновить на вывод поля comment в фомате html.
