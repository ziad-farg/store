<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Enums\CategoryStatus;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'parent_id',
        'category_status',
    ];

    protected $casts = [
        'category_status' => CategoryStatus::class,
    ];

    // use the global scope to filter categories by the authenticated user's store
    protected static function booted()
    {
        static::addGlobalScope(new StoreScope);
    }

    // use this method for searching categories
    public function scopeSearch(Builder $builder, $search)
    {
        $builder->when($search['name'] ?? false, function (Builder $builder, $value) {
            $builder->where('name', 'like', "%{$value}%");
        });
    }

    // [withDefault] use when the parent is null return a default value
    // to avoid make condition in the view
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->withDefault(['name' => 'Primary']);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    // accessor to get the full image url
    public function getImageUrlAttribute()
    {
        // if there is no image return a placeholder image
        if (!$this->image) {
            return "https://placehold.co/335x335";
        }

        // if the image path is not a full url then we will assume that it is a relative path
        if (!Str::startsWith($this->image->path, ['http://', 'https://'])) {
            return asset('storage/' . $this->image->path);
        }

        // otherwise return the image path as is
        return $this->image->path;
    }
}
