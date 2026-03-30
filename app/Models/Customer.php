<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeteletes;

    protected $fillable = [
        'name',
        'email',
        'phone'
    ];

    public function profile()
    {
        return $this->hasOne(CustomerProfile::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
