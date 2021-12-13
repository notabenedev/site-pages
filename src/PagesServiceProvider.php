<?php

namespace Notabenedev\SitePages;

use Illuminate\Contracts\View\View;
use Illuminate\Support\ServiceProvider;
use Notabenedev\SitePages\Console\Commands\PagesMakeCommand;
use App\Folder;
use App\Page;
use Notabenedev\SitePages\Events\FolderChangePosition;
use Notabenedev\SitePages\Filters\PagesGridLg4;
use Notabenedev\SitePages\Filters\PagesGridLg6;
use Notabenedev\SitePages\Filters\PagesGridMd4;
use Notabenedev\SitePages\Filters\PagesGridMd6;
use Notabenedev\SitePages\Filters\PagesGridSm12;
use Notabenedev\SitePages\Filters\PagesGridSm6;
use Notabenedev\SitePages\Filters\PagesGridXl4;
use Notabenedev\SitePages\Filters\PagesGridXl6;
use Notabenedev\SitePages\Listeners\FolderIdsInfoClearCache;
use Notabenedev\SitePages\Observers\FolderObserver;
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
            "site-pages::site.folders.index", "site-pages::site.pages.includes.grid"
        ], function (View $view) {
            $colLg = config("site-pages.foldersLgGrid");
            switch ($colLg){
                case "4":
                    $col = "col-12 col-sm-6 col-lg-4";
                    $grid = [
                        "pages-grid-sm-6" => 576,
                        "pages-grid-md-6" => 768,
                        "pages-grid-lg-6" => 992,
                        "pages-grid-xl-6" => 992,
                    ];
                    break;

                case "6":
                    $col = "col-12 col-md-6";
                    $grid = [
                        "pages-grid-sm-12" => 576,
                        "pages-grid-md-6" => 768,
                        "pages-grid-lg-6" => 992,
                        "pages-grid-xl-6" => 992,
                    ];
                    break;

            };
            $view->with("col", $col);
            $view->with("grid", $grid);
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

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/site-pages.php', 'pages');
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
        $imagecache['pages-grid-lg-6'] = PagesGridLg6::class;
        $imagecache['pages-grid-lg-4'] = PagesGridLg4::class;
        $imagecache['pages-grid-md-6'] = PagesGridMd6::class;
        $imagecache['pages-grid-md-4'] = PagesGridMd4::class;
        $imagecache['pages-grid-sm-6'] = PagesGridSm6::class;
        $imagecache['pages-grid-sm-12'] = PagesGridSm12::class;

        app()->config['imagecache.templates'] = $imagecache;
    }

    protected function addObservers()
    {
        if (class_exists(FolderObserver::class) && class_exists(Folder::class)) {
            Folder::observe(FolderObserver::class);
        }
    }

    protected function addEvents()
    {
        // Обновление галереи.
        //$this->app["events"]->listen(ImageUpdate::class, PageGalleryChange::class);
        // Изменение позиции категории.
        $this->app["events"]->listen(FolderChangePosition::class, FolderIdsInfoClearCache::class);

    }

}
