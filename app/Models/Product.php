<?php

namespace App\Models;

use App\Enums\ProductStatus;
use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'status' => ProductStatus::class,
        'options' => 'array',
    ];

    // use the global scope to filter products by the authenticated user's store
    protected static function booted()
    {
        static::addGlobalScope(new StoreScope);
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
}
