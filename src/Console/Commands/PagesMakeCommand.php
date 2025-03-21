<?php

namespace Notabenedev\SitePages\Console\Commands;

use App\Menu;
use App\MenuItem;
use Illuminate\Console\Command;
use PortedCheese\BaseSettings\Console\Commands\BaseConfigModelCommand;

class PagesMakeCommand extends BaseConfigModelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pages
    {--all : Run all}
    {--menu : Config menu}
    {--models : Export models}
    {--controllers : Export controllers}
    {--observers : Export observers}
    {--policies : Export and create rules} 
    {--vue : Export vue}
    {--scss : Export scss}
    {--js : Export scripts}
    {--only-default : Create only default rules}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Settings for pages and folders';

    protected $vendorName = 'Notabenedev';
    /**
     * Package Name
     * @var string
     *
     */
    protected $packageName = 'SitePages';

    /**
     * The models to  be exported
     * @var array
     */
    protected $models = ["Folder","Page"];

    /**
     * Создание наблюдателей
     *
     * @var array
     */
    protected $observers = ["FolderObserver", "PageObserver"];

    /**
     * Make Controllers
     */
    protected $controllers = [
        "Admin" => ["FolderController","PageController"],
        "Site" => ["FolderController", "PageController"],
    ];

    /**
     * Policies
     * @var array
     *
     */
    protected $ruleRules = [
        ["title" => "Структура страниц",
        "slug" => "folders",
        "policy" => "FolderPolicy",
         ],
        ["title" => "Страницы",
        "slug" => "pages",
        "policy" => "PagePolicy",
         ],

    ];

    /**
     * Стили.
     *
     * @var array
     */
    protected $scssIncludes = [
        "app" => [
            "site-pages/folder",
            "site-pages/page",
            "site-pages/folders-menu",
        ],
    ];

    /**
     * Scripts.
     *
     * @var array
     */
    protected $jsIncludes = [
        "app" => [
            "site-pages/page-carousel",
            "site-pages/pages-modal",
            "site-pages/page-collapse",
        ],
    ];

    /**
     * Vue files folder
     *
     * @var string
     */
    protected $vueFolder = "site-pages";

    /**
     * Vue files list
     *
     * @var array
     */
    protected $vueIncludes = [
        'admin' => [ 'admin-folder-list' => "FolderListComponent",
        ],
        'app' => [],
    ];


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all = $this->option("all");

        if ($this->option('menu') || $all) {

            $this->makeMenu();
        }

        if ($this->option("models") || $all) {
            $this->exportModels();
        }

        if ($this->option("observers") || $all) {
            $this->exportObservers();
        }

        if ($this->option("controllers") || $all) {
            $this->exportControllers("Admin");
            $this->exportControllers("Site");
        }

        if ($this->option("policies") || $all) {
            $this->makeRules();

        }

        if ($this->option("vue") || $all) {
            $this->makeVueIncludes("admin");
            $this->makeVueIncludes("app");
        }

        if ($this->option("scss") || $all) {
            $this->makeScssIncludes("app");
            //$this->makeScssIncludes("admin");
        }

        if ($this->option("js") || $all) {
            $this->makeJsIncludes("app");
        }

    }


    /**
     * Создать меню.
     */
    protected function makeMenu()
    {
        try {
            $menu = Menu::query()->where("key", "admin")->firstOrFail();
        }
        catch (\Exception $exception) {
            return;
        }

        $title = config("site-pages.sitePackageName");
        $itemData = [
            "title" => $title,
            "menu_id" => $menu->id,
            "url" => "#",
            "template" => "site-pages::admin.menu",
        ];

        try {
            $menuItem = MenuItem::query()
                ->where("menu_id", $menu->id)
                ->where("title", "$title")
                ->firstOrFail();
            $this->info("Menu item '{$title}' not updated");
        }
        catch (\Exception $exception) {
            MenuItem::create($itemData);
            $this->info("Menu item '{$title}' was created");
        }
    }
}
