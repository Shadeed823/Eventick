<?php

namespace App\Models;

use App\Constants\TicketSellingMethod;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';

    protected $fillable = [
        'event_name',
        'event_date',
        'auction_end_date',
        'seller_id',
        'buyer_id',
        'seat_number',
        'price',
        'selling_method', // ENUM: Fixed, Auction
        'status',         // ENUM: PendingReview, Available, Sold, Expired, Suspended
        'qr_code',
    ];

    protected $casts = [
        'event_date' => 'datetime', // 👈 cast for easy Carbon handling
        'price' => 'decimal:2',
        'selling_method' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'ticket_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'ticket_id');
    }

    public function auctionHasEnded()
    {
        if ($this->selling_method !== 'Auction' || !$this->auction_end_date) {
            return false;
        }

        return now()->greaterThan($this->auction_end_date);
    }

    // NEW METHOD: Get time remaining until auction ends
    public function getAuctionTimeRemaining()
    {
        if ($this->selling_method !== TicketSellingMethod::AUCTION || !$this->auction_end_date) {
            return null;
        }

        return now()->diff($this->auction_end_date);
    }
}
