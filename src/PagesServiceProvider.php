<?php

namespace Notabenedev\SitePages;

use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Notabenedev\SitePages\Console\Commands\PagesMakeCommand;
use App\Folder;
use App\Page;
use Notabenedev\SitePages\Events\FolderChangePosition;
use Notabenedev\SitePages\Events\PageListChange;
use Notabenedev\SitePages\Facades\FolderActions;
use Notabenedev\SitePages\Filters\PagesGridLg3;
use Notabenedev\SitePages\Filters\PagesGridLg4;
use Notabenedev\SitePages\Filters\PagesGridLg6;
use Notabenedev\SitePages\Filters\PagesGridMd12;
use Notabenedev\SitePages\Filters\PagesGridMd4;
use Notabenedev\SitePages\Filters\PagesGridMd6;
use Notabenedev\SitePages\Filters\PagesGridSm12;
use Notabenedev\SitePages\Filters\PagesGridSm6;
use Notabenedev\SitePages\Filters\PagesGridXl3;
use Notabenedev\SitePages\Filters\PagesGridXl4;
use Notabenedev\SitePages\Filters\PagesGridXl6;
use Notabenedev\SitePages\Filters\PagesShowThumb;
use Notabenedev\SitePages\Listeners\FolderIdsInfoClearCache;
use Notabenedev\SitePages\Listeners\FolderPagesIdsClearCache;
use Notabenedev\SitePages\Listeners\PageGalleryChange;
use Notabenedev\SitePages\Observers\FolderObserver;
use Notabenedev\SitePages\Observers\PageObserver;
use PortedCheese\BaseSettings\Events\ImageUpdate;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //Публикация конфигурации
        $this->publishes([__DIR__.'/config/site-pages.php' => config_path('site-pages.php'),
                ], 'config');

        //Подключение миграций
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Подключение шаблонов.
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'site-pages');
        view()->composer([
            "site-pages::site.folders.index"
        ], function (View $view) {
            $colLg = config("site-pages.foldersLgGrid");
            $colGrid = $this->setGrid($colLg);
            $view->with("perRow", $colLg);
            $view->with("col", $colGrid[0]);
            $view->with("grid", $colGrid[1]);
        });
        view()->composer([
            "site-pages::site.pages.includes.grid"
        ], function (View $view) {
            $colLg = config("site-pages.pagesLgGrid");
            $colGrid = $this->setGrid($colLg);
            $view->with("perRow", $colLg);
            $view->with("col", $colGrid[0]);
            $view->with("grid", $colGrid[1]);
        });
        view()->composer("site-pages::site.includes.folders-menu", function (View $view){
            $view->with("foldersTree", FolderActions::getTree());
        });

        //Console
        if ($this->app->runningInConsole()){
            $this->commands([
                PagesMakeCommand::class,
            ]);
        }

        // Подключение метатегов.
        $seo = app()->config["seo-integration.models"];
        $seo["folders"] = Folder::class;
        $seo["pages"] = Page::class;
        app()->config["seo-integration.models"] = $seo;

        // Подключаем изображения.
        $imagecache = app()->config['imagecache.paths'];
        $imagecache[] = 'storage/folders';
        $imagecache[] = 'storage/pages';
        $imagecache[] = 'storage/gallery/pages';
        app()->config['imagecache.paths'] = $imagecache;
        // Шаблоны изображений
        $this->extendImages();

        // Подключаем галерею.
        $gallery = app()->config["gallery.models"];
        $gallery["pages"] = Page::class;
        app()->config["gallery.models"] = $gallery;

        //Подключаем роуты
        if (config("site-pages.folderAdminRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/admin/folder.php");
        }
        if (config("site-pages.folderSiteRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/site/folder.php");
        }
        if (config("site-pages.pageAdminRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/admin/page.php");
        }
        if (config("site-pages.pageSiteRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/site/page.php");
        }

        // Assets.
        $this->publishes([
            __DIR__ . '/resources/js/components' => resource_path('js/components/vendor/site-pages'),
            __DIR__ . '/resources/js/scripts' => resource_path('js/vendor/site-pages'),
            __DIR__ . "/resources/sass" => resource_path("sass/vendor/site-pages")
        ], 'public');

        // Observers
        $this->addObservers();

        // Events
        $this->addEvents();
      
    }

    protected function setGrid($colLg){
        switch ($colLg){
            case "4":
                $col = "col-12 col-md-6 col-lg-4";
                $grid = [
                    "pages-grid-xl-4" => 1200,
                    "pages-grid-lg-4" => 992,
                    "pages-grid-md-6" => 768,
                    "pages-grid-sm-12" => 576,
                ];
                break;

            case "6":
                $col = "col-12 col-md-6";
                $grid = [
                    "pages-grid-xl-6" => 1200,
                    "pages-grid-lg-6" => 992,
                    "pages-grid-md-6" => 768,
                    "pages-grid-sm-12" => 576,
                ];
                break;

            case "3":
                $col = "col-12 col-md-6 col-lg-3";
                $grid = [
                    "pages-grid-xl-3" => 1200,
                    "pages-grid-lg-3" => 992,
                    "pages-grid-md-6" => 768,
                    "pages-grid-sm-12" => 576,
                ];
                break;

        };
        return [$col, $grid];
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/site-pages.php', 'site-pages');
        $this->initFacades();
    }

    /**
     * Подключение Facade.
     */
    protected function initFacades()
    {
        $this->app->singleton("folder-actions", function () {
            $class = config("site-pages.folderFacade");
            return new $class;
        });
        $this->app->singleton("page-actions", function () {
            $class = config("site-pages.pageFacade");
            return new $class;
        });
    }

    /**
     * Стили для изображений.
     */
    private function extendImages()
    {
        $imagecache = app()->config['imagecache.templates'];

        $imagecache['pages-grid-xl-6'] = PagesGridXl6::class;
        $imagecache['pages-grid-xl-4'] = PagesGridXl4::class;
        $imagecache['pages-grid-xl-3'] = PagesGridXl3::class;
        $imagecache['pages-grid-lg-6'] = PagesGridLg6::class;
        $imagecache['pages-grid-lg-4'] = PagesGridLg4::class;
        $imagecache['pages-grid-lg-3'] = PagesGridLg3::class;
        $imagecache['pages-grid-md-12'] = PagesGridMd12::class;
        $imagecache['pages-grid-md-6'] = PagesGridMd6::class;
        $imagecache['pages-grid-md-4'] = PagesGridMd4::class;
        $imagecache['pages-grid-sm-6'] = PagesGridSm6::class;
        $imagecache['pages-grid-sm-12'] = PagesGridSm12::class;
        $imagecache['pages-show-thumb'] = PagesShowThumb::class;

        app()->config['imagecache.templates'] = $imagecache;
    }

    protected function addObservers()
    {
        if (class_exists(FolderObserver::class) && class_exists(Folder::class)) {
            Folder::observe(FolderObserver::class);
        }
        if (class_exists(PageObserver::class) && class_exists(Page::class)) {
            Page::observe(PageObserver::class);
        }
    }

    protected function addEvents()
    {
        // Обновление галереи.
        $this->app["events"]->listen(ImageUpdate::class, PageGalleryChange::class);
        // Изменение позиции категории.
        $this->app["events"]->listen(FolderChangePosition::class, FolderIdsInfoClearCache::class);
        // Изменение  категории страницы
        $this->app["events"]->listen(PageListChange::class, FolderPagesIdsClearCache::class);

    }

}
