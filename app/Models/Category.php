<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'parent_id',
    ];

    // use this method for searching categories
    public function scopeSearch(Builder $builder, $search)
    {
        $builder->when($search['name'] ?? false, function (Builder $builder, $value) {
            $builder->where('name', 'like', "%{$value}%");
        });
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
