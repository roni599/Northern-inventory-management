<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_name', 'product_img', 'expiry_time', 'quantity', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function organizations()
    {
        return $this->belongsToMany(Organization::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function procurements()
    {
        return $this->hasMany(Procurement::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
