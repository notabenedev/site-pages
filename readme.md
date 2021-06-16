#Pages
Install

Заполнить конфиг необходимыми данными

php artisan migrate

php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force
php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=config --force

php artisan make:category-product
                        {--all : Run all}
                        {--config : Copy config}
                        {--menu : Config menu}
                        {--models : Export models}
                        {--controllers : Export controllers}
                        {--policies : Export and create rules}
                        {--only-default : Create default rules}
                        {--vue : Export vue components}
##Description
