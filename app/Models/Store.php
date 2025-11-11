<?php

namespace App\Models;

use App\Enums\OpeningStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Store extends Model
{
    use HasFactory, Notifiable;

    // for remembering the varables and consts
    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    const DELETED_AT = 'deleted_at';

    protected $table = 'stores';

    protected $primaryKey = 'id';

    protected $keyType = 'int';

    protected $connection = 'mysql';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'address',
        'slug',
        'description',
        'opening_status',
    ];

    protected $casts = [
        'opening_status' => OpeningStatus::class,
    ];

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
