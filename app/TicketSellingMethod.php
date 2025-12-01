<?php

namespace App\Constants;

class TicketSellingMethod
{
    public const FIXED = 'Fixed';
    public const AUCTION = 'Auction';

    public static function all(): array
    {
        return [
            self::FIXED,
            self::AUCTION,
        ];
    }
}
