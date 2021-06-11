<?php

namespace Notabenedev\SitePages\Facades;

use Illuminate\Support\Facades\Facade;
use Notabenedev\SitePages\Helpers\FolderActionsManager;

/**


 *
 * @see CategoryActionsManager
 */
class FolderActions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "folder-actions";
    }
}