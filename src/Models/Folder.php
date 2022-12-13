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

        //published folder and child

        if ($parentPublished){
            // change publish
            $this->publish();
            if($published){
                $this->unPublishChildren($collection);
                $this->unPublishChildren($this->pages()->get(), false);
            }
            return true;
        }
        else
        {
            if (!$published){
                return false;
            }
            else {
                $this->publish();
                $this->unPublishChildren($collection);
                $this->unPublishChildren($this->pages()->get(), false);
                return true;
            }
        }

    }


    /**
     * UnPublish child
     *
     * @param $collection
     * @return void
     *
     */
    protected function unPublishChildren($collection, $cascade = true){
        if ($collection->count() > 0) {
            foreach ($collection as $child) {
                $child->published_at = null;
                $child->save();
                if ($cascade) {
                    $this->unPublishChildren($child->children()->get());
                    $this->unPublishChildren($child->pages, false);
                }
            }
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
