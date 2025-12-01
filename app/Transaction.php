<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'transaction_id';
    public $timestamps = false;

    protected $fillable = [
        'ticket_id',
        'buyer_id',
        'seller_id',
        'amount',
        'payment_method', // ENUM: Credit Card, Apple Pay, STC Pay, Bank Transfer
        'payment_status', // ENUM: Pending, Verified, Failed
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_method' => 'string',
        'payment_status' => 'string',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
