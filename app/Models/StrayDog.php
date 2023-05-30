<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrayDog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'area_id', 'animal_type', 'color', 'temperament', 
        'gender', 'size', 'description', 'map_link', 'image',
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
}