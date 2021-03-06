<?php

namespace Notabenedev\SitePages\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use PortedCheese\BaseSettings\Traits\ShouldGallery;
use PortedCheese\BaseSettings\Traits\ShouldImage;
use PortedCheese\BaseSettings\Traits\ShouldSlug;
use PortedCheese\SeoIntegration\Traits\ShouldMetas;

class Page extends Model
{
    use HasFactory, ShouldMetas, ShouldSlug, ShouldImage, ShouldGallery;

    protected $fillable = [
        'title',
        'slug',
        'short',
        'description',
        'accent',
        'comment',
        'folder_id',
    ];

    protected $metaKey = "pages";
    protected $imageKey = "main_image";

    protected static function booting() {

        parent::booting();

    }


    /**
     * Folder publish status
     *
     * @return mixed
     */


    public function isFolderPublished(){
        $folder = $this->folder;
        return $folder->published_at;
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
     * Page folder
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     */
    public function folder(){
        return $this->belongsTo(\App\Folder::class);
    }

    /**
     * Изменить дату создания.
     *
     * @param $value
     * @return string
     */
    public function getCreatedAtAttribute($value)
    {
        return datehelper()->changeTz($value);
    }

    /**
     * Изменить дату создания.
     *
     * @param $value
     * @return string
     */
    public function getPublishedAtAttribute($value)
    {
        return datehelper()->changeTz($value);
    }

    /**
     * Данные для тизера.
     *
     * @return mixed
     */
    public function getTeaserData()
    {
        $key = "pageTeaserData:{$this->id}";
        $id = $this->id;
        return Cache::rememberForever($key, function () use ($id) {
            return \App\Page::query()
                ->where("id", $id)
                ->with("cover")
                ->first();
        });
    }

    /**
     * Очистить кэш.
     */
    public function clearCache()
    {
        Cache::forget("pageTeaserData:{$this->id}");
    }

}
