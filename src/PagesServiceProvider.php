<?php

namespace Notabenedev\SitePages;

use Illuminate\Support\ServiceProvider;
use Notabenedev\SitePages\Console\Commands\PagesMakeCommand;
use App\Folder;
use App\Page;

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

        // Подключаем галерею.
        $gallery = app()->config["gallery.models"];
        $gallery["pages"] = Page::class;
        app()->config["gallery.models"] = $gallery;

        //Подключаем роуты
        if (config("site-pages.folderAdminRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/admin/folder.php");
            $this->loadRoutesFrom(__DIR__."/routes/admin/page.php");
        }

        //подключаем шаблоны
        $this ->loadViewsFrom(__DIR__."/resources/views", "site-pages");

        // Assets.
        $this->publishes([
            __DIR__ . '/resources/js/components' => resource_path('js/components/vendor/site-pages'),
//            __DIR__ . '/resources/js/scripts' => resource_path('js/vendor/site-pages'),
//            __DIR__ . "/resources/sass" => resource_path("sass/vendor/site-pages")
        ], 'public');
        
        //Console
        if ($this->app->runningInConsole()){
            $this->commands([
                PagesMakeCommand::class,
            ]);
        }
      
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
}
