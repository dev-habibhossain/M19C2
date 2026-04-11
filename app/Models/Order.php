<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_no',
        'status',
        'sub_total',
        'discount',
        'tax',
        'grand_total',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function scopeBetweenDates($query, ?string $from, ?string $to)
    {
        if($from && $to) {
            return $query->whereBetween('created_at', [$from, $to]);
        }
        return $query;
    }

    public function totalPaidAmount(): float
    {
        return (float) $this->payments()->sum('amount');
    }

    public function dueAmount(): float
    {
        return (float) $this->grand_total - $this->totalPaidAmount();
    }

}
