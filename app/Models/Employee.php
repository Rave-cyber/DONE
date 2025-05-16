<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'phone', 
        'position', 
        'hire_date', 
        'status',
        'user_id'
    ];
    //

    protected $dates = ['hire_date'];

    public function getFullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'employee_assignments', 'employee_id', 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
