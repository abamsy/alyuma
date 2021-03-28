<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Plant;
use App\Models\Point;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function plant()
    {
        return $this->hasOne(Plant::class);
    }
    
    public function point()
    {
        return $this->hasOne(Point::class);
    }

    public function ballocations()
    {
        return $this->hasManyThrough(Allocation::class, Plant::class);
    }

    public function lallocations()
    {
        return $this->hasManyThrough(Allocation::class, Point::class);
    }

    public function isSuperAdmin(){
        
        if ($this->role == 'super admin'){
            return true;
        }

        return false; 
    }

    public function isAdmin(){
        
        if ($this->role == 'admin'){
            return true;
        }

        return false; 
    }

    public function isDispatcher(){
        
        if ($this->role == 'dispatcher'){
            return true;
        }

        return false; 
    }

    public function isReceiver(){
        
        if ($this->role == 'receiver'){
            return true;
        }

        return false; 
    }
}
