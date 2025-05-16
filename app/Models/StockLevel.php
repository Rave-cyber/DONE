<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
