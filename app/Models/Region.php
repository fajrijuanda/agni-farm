<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'shopee_url',
        'order_index',
    ];

    /**
     * Get users for this region
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get products for this region
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
