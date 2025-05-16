<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'supplier_id',
        'transaction_type',
        'quantity',
        'price',
        'reason',
    ];

    public function item()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
