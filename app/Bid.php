<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $table = 'bids';
    protected $primaryKey = 'bid_id';
    public $timestamps = false;

    protected $fillable = [
        'ticket_id',
        'buyer_id',
        'bid_amount',
        'bid_time',
        'status', // Added status field
    ];

    protected $casts = [
        'bid_amount' => 'decimal:2',
        'bid_time' => 'datetime',
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

    // Scope for pending bids
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Scope for accepted bids
    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    // Scope for rejected bids
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Check if bid is pending
    public function isPending()
    {
        return $this->status === 'pending';
    }

    // Check if bid is accepted
    public function isAccepted()
    {
        return $this->status === 'accepted';
    }

    // Check if bid is rejected
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
