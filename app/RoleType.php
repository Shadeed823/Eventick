<?php

namespace App\Constants;

class RoleType
{
    public const ADMIN = 'Admin'; // id = 1
    public const SELLER = 'Seller'; // id = 2
    public const BUYER = 'Buyer';   // id = 3

    public static function all(): array
    {
        return [
            self::SELLER,
            self::BUYER,
        ];
    }

    public static function ids(): array
    {
        return [
            'Seller' => 2,
            'Buyer'  => 3,
        ];
    }
}
