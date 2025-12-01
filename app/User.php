<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'status', // ENUM: Active, Suspended, Deleted
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'status' => 'string',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // =====================
    // 🔹 Relationships
    // =====================

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'buyer_id');
    }

    public function ticketsSold()
    {
        return $this->hasMany(Ticket::class, 'seller_id');
    }

    public function ticketsBought()
    {
        return $this->hasMany(Ticket::class, 'buyer_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'buyer_id');
    }

    public function transactionsAsBuyer()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    public function transactionsAsSeller()
    {
        return $this->hasMany(Transaction::class, 'seller_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class, 'user_id');
    }

    public function complaintsHandled()
    {
        return $this->hasMany(Complaint::class, 'admin_id');
    }
}
