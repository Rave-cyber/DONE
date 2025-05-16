<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiveOrder extends Model
{
    protected $fillable = 
    ['supplier_id', 
    'order_number', 
    'status', 
    'total_price'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(ReceiveOrderItem::class);
    }
}
