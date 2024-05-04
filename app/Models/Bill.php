<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // Specify the primary key
    public $incrementing = false; // Tell Laravel not to assume it's auto-incrementing
    protected $keyType = 'string'; // Define the data type of the primary key
    protected $fillable = ['status', 'order_date', 'user_id','assignfor'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
