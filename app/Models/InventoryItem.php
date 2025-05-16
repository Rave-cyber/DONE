<?php

namespace App\Models;
use App\Models\StockTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items'; // Explicitly set table name

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'status'
    ];

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class, 'item_id');
    }

    public function getLatestPriceAttribute()
    {
        return $this->stockTransactions()
            ->where('transaction_type', 'stock_in')
            ->latest()
            ->value('price');
    }
}