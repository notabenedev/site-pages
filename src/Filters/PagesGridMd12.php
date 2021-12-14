<?php

namespace Notabenedev\SitePages\Filters;

use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image as File;

class PagesGridMd12 implements FilterInterface {

    public function applyFilter(File $image)
    {
        return $image
            ->fit(768, 512);
    }
}