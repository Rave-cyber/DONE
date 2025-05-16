<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Order extends Model
{
    use HasFactory;

    // Add all fields that can be mass-assigned
    protected $fillable = [
        'order_name',
        'weight',
        'date',
        'service_type',
        'status',
        'payment_method',
        'payment_status',
        'amount',
        'special_instructions',
        'is_archived'
    ];

    protected $casts = [
        'service_type' => 'array',
        'date' => 'datetime',
    ];

    // Relationship to status logs
    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_assignments', 'order_id', 'employee_id');
    }

    // Method to update status and log the change
    public function updateStatus(string $newStatus, ?int $userId = null)
    {
        // Log the status change
        $this->statusLogs()->create([
            'status' => $newStatus,
            'changed_at' => now(),
            'user_id' => $userId ?? Auth::id(),
        ]);

        // Update the current status
        $this->status = $newStatus;
        $this->save();
    }
}