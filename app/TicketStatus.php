<?php

namespace App\Constants;

class TicketStatus
{

    const PENDING_REVIEW = 'PendingReview';

    public const AVAILABLE = 'Available';
    public const SOLD = 'Sold';
    public const EXPIRED = 'Expired';
    public const SUSPENDED = 'Suspended';

    public static function all(): array
    {
        return [
            self::AVAILABLE,
            self::SOLD,
            self::EXPIRED,
            self::SUSPENDED,
            self::PENDING_REVIEW,
        ];
    }
}
