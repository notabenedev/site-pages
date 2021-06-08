<?php

namespace Notabenedev\SitePages;

use Illuminate\Support\ServiceProvider;
use Notabenedev\SitePages\Console\Commands\PagesMakeCommand;
use Notabenedev\SitePages\Models\Folder;

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
        $this->publishes([__DIR__.'/config/pages.php' => config_path('pages.php'),
                ], 'config');

        //Подключение миграций
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Подключение метатегов.
        $seo = app()->config["seo-integration.models"];
        $seo["folders"] = Folder::class;
        app()->config["seo-integration.models"] = $seo;

        // Подключаем изображения.
        $imagecache = app()->config['imagecache.paths'];
        $imagecache[] = 'storage/folders';
        app()->config['imagecache.paths'] = $imagecache;

        //Подключаем роуты
        if (config("site-pages.folderAdminRoutes")) {
            $this->loadRoutesFrom(__DIR__."/routes/admin/folder.php");
        }
        if (config("site-pages.folderSiteRoutes")) {
            $this->loadRoutesFrom(__DIR__ . "/routes/site/folder.php");
        }
        
        //подключаем шаблоны
        $this ->loadViewsFrom(__DIR__."/resources/views", "site-pages");
        
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
        //$this->app->make('Http\Controllers\Admin\FolderController');

    }
}
