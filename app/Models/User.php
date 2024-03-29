<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'administrator','current_role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userContact()
    {
        return $this->hasOne(UserContact::class);
    }

    public function strayDogs()
    {
        return $this->hasMany(StrayDog::class);
    }

    public function vets()
    {
        return $this->hasMany(Vet::class);
    }

    public function adoptions()
    {
        return $this->hasMany(Adoption::class);
    }

    public function rescues()
    {
        return $this->hasMany(Rescue::class);
    }

    // public function currentRole(): BelongsTo
    // {
    //     return $this->belongsTo(Role::class, 'current_role_id');
    // }
}
