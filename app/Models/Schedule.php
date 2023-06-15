<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'vet_id', 'day_name', 'open_hour', 'close_hour', 'fullday', 
    ];

    public function vet()
    {
        return $this->belongsTo(Vet::class);
    }
}
