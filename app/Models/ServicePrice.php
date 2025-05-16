<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePrice extends Model
{
    protected $fillable = [
        'service_name',
        'base_price'
    ];
    
    // Optional: Constants for service names
    const WASH = 'Wash';
    const FOLD = 'Fold';
    const IRONING = 'Ironing';
}