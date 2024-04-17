<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'price',
        'slug',
        'is_active',
    ];


    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getPriceAttribute()
    {
        $user = Auth::user();
        switch ($user->type) {
            case 'normal':
                return $this->attributes['price']; // Standard price
            case 'silver':
                return $this->attributes['price'] * 0.9; // 10% discount for Premium users
            case 'gold':
                return $this->attributes['price'] * 0.8; // 20% discount for VIP users
            default:
                return $this->attributes['price'];
        }
    }

    public function getImageAttribute($value)
    {
        // Check if the image attribute starts with "http" (indicating an external URL)
        if (strpos($value, 'http') === 0) {
            return $value;
        }
        $baseUrl = config('app.url'); // Use Laravel's configuration
        return $this->attributes['image'] = $baseUrl . ':8000/' . $value;
    }
}
