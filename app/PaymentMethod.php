<?php

namespace App\Constants;

class PaymentMethod
{
    public const CREDIT_CARD = 'Credit Card';
    public const APPLE_PAY = 'Apple Pay';
    public const STC_PAY = 'STC Pay';
    public const BANK_TRANSFER = 'Bank Transfer';

    public static function all(): array
    {
        return [
            self::CREDIT_CARD,
            self::APPLE_PAY,
            self::STC_PAY,
            self::BANK_TRANSFER,
        ];
    }
}
