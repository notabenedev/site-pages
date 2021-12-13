<?php

namespace Notabenedev\SitePages\Facades;


use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Facade;

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