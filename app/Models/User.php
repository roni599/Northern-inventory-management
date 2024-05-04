<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = [
        'full_name', 'email', 'password', 'profile_img', 'phone', 'address', 'status'
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

}
