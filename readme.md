#Pages
Install

php artisan migrate

php artisan vendor:publish --provider="Notabenedev\SitePages\PagesServiceProvider" --tag=public --force

php artisan make:category-product
                        {--all : Run all}
                        {--menu : Config menu}
                        {--models : Export models}
                        {--controllers : Export controllers}
                        {--policies : Export and create rules}
                        {--only-default : Create default rules}
##Description
