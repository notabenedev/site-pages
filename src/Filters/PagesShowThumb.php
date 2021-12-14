<?php

namespace Notabenedev\SitePages\Filters;

use Intervention\Image\Facades\Image;
use Intervention\Image\Filters\FilterInterface;
use Intervention\Image\Image as File;

class PagesShowThumb implements FilterInterface {

    public function applyFilter(File $image)
    {
        return $image
            ->resize(97, 65, function ($constraint) {
                $constraint->upsize();
                $constraint->aspectRatio();
            });
    }
}