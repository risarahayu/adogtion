<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrayDog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'area_id', 'dog_type', 'color', 'temperament',
        'gender', 'size', 'description', 'map_link',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function rescue()
    {
        return $this->hasOne(Rescue::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
