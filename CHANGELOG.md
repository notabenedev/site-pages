## 4.0.8 Page-collapse для modal-view
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
- если был удален - восстановить файл page-collapse.js: 
php artisan make:pages --js

Обновлен шаблон site.pages.includes.show-top-section

## 4.0.0-4.0.6  Bootstrap 5
- Новый фильтр для xxl: pages-grid-xxl-4, pages-grid-xxl-3, pages-grid-xxl-6
- Переписан на js scripts/pages-modal.js
- Правки в стилях folders-menu, folder, page
- обновлены шаблоны admin.menu, admin.pages.index
- обновлены шаблоны site.folders.includes/show-modal, site.pages.includes.*, site.pages.simple.sidebar
- 
Обновление:
- Удалить подключение page-collapse.js в файле  resources\js/vendor/app-js-includes.js
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
- проверить переопределение шаблонов

## 3.2.1
Обновлен контроллер site/PageCintroller
## 3.2.0
Обновлены шаблоны вывода групп блоков (в тч Табы (tabs))
- cвязка с site-blocks ^v1.1
  Проверить переопределение:
- шаблонов site.pages.show, site.pages.includes.show-top-section, site.pages.simple.page
- Site/PageController > show
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
