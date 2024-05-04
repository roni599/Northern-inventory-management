<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $fillable = [
        'organization_name', 'status'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function user()
    {
        return $this->hasOne(User::class);
    }
}
