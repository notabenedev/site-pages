<?php

namespace Notabenedev\SitePages\Facades;

use Illuminate\Support\Facades\Facade;
use Notabenedev\SitePages\Helpers\PageActionsManager;

/**
 *
 * Class PageActions
 * @package Notabenedev\SitePages\Facades
 *
 */
class PageActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "page-actions";
    }
}