<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    const ROLE_ADMIN = 'admin';
    const ROLE_EMPLOYEE = 'employee';
    const ROLE_CUSTOMER = 'customer';    

    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEmployee()
    {
        return $this->role === self::ROLE_EMPLOYEE;
    }

    public function isCustomer()
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

        public function employee()
    {
        return $this->hasOne(Employee::class);
    }
}
