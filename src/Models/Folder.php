<?php

namespace Notabenedev\SitePages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use PortedCheese\BaseSettings\Traits\ShouldImage;
use PortedCheese\BaseSettings\Traits\ShouldSlug;
use PortedCheese\SeoIntegration\Traits\ShouldMetas;
use function Symfony\Component\String\s;

class Folder extends Model
{
    use HasFactory, ShouldSlug, ShouldImage, ShouldMetas;
    
    protected $fillable = [
        "title",
        "slug",
        "short",
    ];
    protected $metaKey = "folders";
    protected $imageKey = "main_image";

    protected static function booting() {

        parent::booting();
    }

    /**
     * Родительская категолрия.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(\App\Folder::class, "parent_id");
    }

    /**
     * Дочерние категории.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(\App\Folder::class, "parent_id");
    }

    /**
     * Get parent publish status
     *
     * @return \Illuminate\Support\Carbon|mixed
     */

    public function isParentPublished(){

        $parent = $this->parent()->first();
        return $parent ? $parent->published_at : now();

    }

    /**
     * Change publish status
     *
     */
    public function publish()
    {
        $this->published_at = $this->published_at  ? null : now();
        $this->save();
    }
    /**
     * Change publish status all children and pages
     *
     */

    public function publishCascade()
    {

        $published =  $this->published_at;
        $children = $this->children();
        $collection = $children->get();
        $parentPublished = $this->isParentPublished();

        //folder pages
        $pages = $this->pages()->get();
        foreach ($pages as $page) {
            if ($published || !$parentPublished)
                $page->publish();
        }

        // child folders
        if ($collection->count() > 0) {

            //unpublished folder and child folders
            if ($published || !$parentPublished) {
                $this->published_at = null;
                $this->save();

                foreach ($collection as $child) {
                    $this->publish($child);
                }

            } else {
                //publish folder
                $this->publish();
            }
            return
                redirect()
                    ->back();

        }
        // leaf folders
        else {
            //can't publish the leaf when parent is unpublished
            if (!$published  && !$parentPublished) {
                return redirect()
                    ->back();
            }
            $this->publish();

            return redirect()
                ->back();
        }
    }

    /**
     * Folder pages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany(\App\Page::class);
    }

    /**
     * Уровень вложенности.
     *
     * @return int
     */
    public function getNestingAttribute()
    {
        if (empty($this->parent_id)) {
            return 1;
        }
        return $this->parent->nesting + 1;
    }
}
