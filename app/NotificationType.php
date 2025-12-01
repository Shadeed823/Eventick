<?php

namespace App\Constants;

class NotificationType
{
    public const PURCHASE_UPDATE = 'Purchase Update';
    public const BID_UPDATE = 'Bid Update';
    public const AUCTION_UPDATE = 'Auction Update';
    public const PAYMENT_REMINDER = 'Payment Reminder';
    public const ADMIN_NOTICE = 'Admin Notice';
    public const COMPLAINT_RESPONSE = 'Complaint Response';
    public const TICKET_APPROVAL = 'Ticket Approval';

    public static function all(): array
    {
        return [
            self::PURCHASE_UPDATE,
            self::BID_UPDATE,
            self::AUCTION_UPDATE,
            self::PAYMENT_REMINDER,
            self::ADMIN_NOTICE,
            self::COMPLAINT_RESPONSE,
            self::TICKET_APPROVAL,
        ];
    }
}
