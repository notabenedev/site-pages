<?php

namespace Notabenedev\SitePages\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use PortedCheese\BaseSettings\Events\ImageUpdate;
use App\Page;

class PageGalleryChange
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ImageUpdate $event
     * @return void
     */
    public function handle(ImageUpdate $event)
    {
        $morph = $event->morph;
        if (! empty($morph) && get_class($morph) == Page::class) {
            $morph->updated_at = now();
            $morph->save();
        }
    }
}
