<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rescue extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'stray_dog_id', 'vet_id', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stray_dog()
    {
        return $this->belongsTo(StrayDog::class);
    }

    public function vet()
    {
        return $this->belongsTo(Vet::class);
    }
}
