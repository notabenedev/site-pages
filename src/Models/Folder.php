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
        static::creating(function (\App\Folder $model) {
            if ($model->isParentPublished())  $model->published_at = now();
        });
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
