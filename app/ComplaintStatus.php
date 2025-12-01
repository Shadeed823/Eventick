<?php

namespace App\Constants;

class ComplaintStatus
{
    public const PENDING = 'Pending';
    public const RESOLVED = 'Resolved';
    public const REJECTED = 'Rejected';

    public static function all(): array
    {
        return [
            self::PENDING,
            self::RESOLVED,
            self::REJECTED,
        ];
    }
}
