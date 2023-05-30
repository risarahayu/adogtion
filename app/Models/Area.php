<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function vets()
    {
        return $this->hasMany(Vet::class);
    }

    public function stray_dogs()
    {
        return $this->hasMany(StrayDog::class); 
    }
}
