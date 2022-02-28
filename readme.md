#Pages
Install

- Заполнить конфиг необходимыми данными
- php artisan migrate
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
- php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=config
- php artisan make:pages
                        {--all : Run all}
                        {--menu : Config menu}
                        {--models : Export models}
                        {--controllers : Export controllers}
                        {--policies : Export and create rules}
                        {--only-default : Create default rules}
                        {--vue : Export vue components}
                        {--js : Export scripts}
                        {--scss: Export scss}
- npm install flickity
- npm install flickity-as-nav-for
- npm install jquery-bridget

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
    
   
