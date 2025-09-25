<?php

namespace App\Models;


use App\Enums\ProductStatus;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
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
}
