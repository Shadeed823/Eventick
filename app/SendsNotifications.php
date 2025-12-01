<?php

namespace App\Traits;

use App\Models\Notification;
use App\Constants\NotificationType;

trait SendsNotifications
{
    /**
     * Send a notification to a user
     */
    protected function sendNotification($userId, $message, $type = NotificationType::BID_UPDATE)
    {
        return Notification::create([
            'user_id' => $userId,
            'message' => $message,
            'type' => $type,
            'status' => 'Unread',
            'created_at' => now(),
        ]);
    }

    /**
     * Send multiple notifications to different users
     */
    protected function sendBulkNotifications($userIds, $message, $type = NotificationType::BID_UPDATE)
    {
        $notifications = [];
        foreach ($userIds as $userId) {
            $notifications[] = [
                'user_id' => $userId,
                'message' => $message,
                'type' => $type,
                'status' => 'Unread',
                'created_at' => now(),
            ];
        }

        Notification::insert($notifications);
    }

    /**
     * Send email notification in addition to in-app notification
     */
    protected function sendEmailNotification($user, $subject, $message)
    {
        // Implement email sending logic here
        // Mail::to($user->email)->send(new NotificationEmail($subject, $message));
    }
}
