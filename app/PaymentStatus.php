<?php

namespace App\Constants;

class PaymentStatus
{
    public const PENDING = 'Pending';
    public const VERIFIED = 'Verified';
    public const FAILED = 'Failed';

    public static function all(): array
    {
        return [
            self::PENDING,
            self::VERIFIED,
            self::FAILED,
        ];
    }
}
