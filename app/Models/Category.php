<?php

namespace App\Models;

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
}
