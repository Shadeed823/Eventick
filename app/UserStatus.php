<?php

namespace App\Constants;

class UserStatus
{
    public const ACTIVE = 'Active';
    public const SUSPENDED = 'Suspended';
    public const DELETED = 'Deleted';

    public static function all(): array
    {
        return [
            self::ACTIVE,
            self::SUSPENDED,
            self::DELETED,
        ];
    }
}
