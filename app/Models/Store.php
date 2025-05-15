<?php

namespace App\Models;

use App\Enums\OpeningStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $casts = [
        'opening_status' => OpeningStatus::class,
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
