<?php

namespace App\Models;


use Illuminate\Support\Str;
use App\Enums\ProductStatus;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'store_id',
        'category_id',
        'name',
        'slug',
        'price',
        'compare_price',
        'options',
        'rating',
        'featured',
        'status',
        'description',
    ];

    protected $casts = [
        'status' => ProductStatus::class,
        'options' => 'array',
    ];

    // use the global scope to filter products by the authenticated user's store
    // if the user is not value the mean that admin is logged in and can see all products
    // so we will not apply the scope
    protected static function booted()
    {
        static::addGlobalScope(new StoreScope);
    }

    public function scopeSearch(Builder $builder, $search)
    {
        $builder->when($search['name'] ?? false, function ($builder, $value) {
            $builder->where('name', 'like', "%{$value}%");
        });
    }

    // scope to get only active products
    public function scopeActive(Builder $builder)
    {
        $builder->where('status', ProductStatus::ACTIVE);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the status label for display
     */
    public function getStatusLabelAttribute()
    {
        return $this->status == ProductStatus::ACTIVE ? 'Active' : ($this->status == ProductStatus::DRAFT ? 'Draft' : ($this->status == ProductStatus::ARCHIVED ? 'Archived' : 'Unknown'));
    }
    /**
     * Get the Featured label for display
     */
    public function getFeaturedLabelAttribute()
    {
        return $this->featured ? 'Featured' : 'Normal';
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,     // the first parameter is the related model
            'product_tags', // the second parameter is the pivot table name
            'product_id',   // the third parameter is the foreign key of the current model in the pivot table
            'tag_id',       // the fourth parameter is the foreign key of the related model in the pivot table
            'id',           // the fifth parameter is the local key of the current model
            'id'            // the sixth parameter is the local key of the related model
        );
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

    // accessor to get sale percentage
    public function getSalePercentageAttribute()
    {
        if (!$this->compare_price) {
            return;
        }

        return -floor((($this->compare_price - $this->price) / $this->compare_price) * 100) . '%';
    }
}
