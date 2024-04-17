<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'username',
        'avatar' ,
        'type',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = Hash::make($value); // Hash the password before storing
    }

    public function getAvatarAttribute($value){
        if (strpos($value, 'http') === 0) {
            return $value;
        }
        $baseUrl = config('app.url'); // Use Laravel's configuration
        return $this->attributes['avatar'] = $baseUrl . ':8000/' . $value;
    }
}
