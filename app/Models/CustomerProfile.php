<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $fillable =[
        'customer_id',
        'dob',
        'gender',
        'billing_address',
        'shipping_address',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
