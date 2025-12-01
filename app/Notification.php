<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'notification_id';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'message',
        'type',   // ENUM: Purchase Update, Bid Update, Admin Notice, Complaint Response
        'status', // ENUM: Read, Unread
    ];

    protected $casts = [
        'type' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
