<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Support\Facades\Notification;

class NotificationService
{
    /**
     * Send a notification to a specific user.
     *
     * @param User $user
     * @param string $message
     * @param string $url
     */
    public function sendToUser(User $user, string $message, string $url): void
    {
        $user->notify(new GeneralNotification($message, $url));
    }

    /**
     * Send a notification to all users with a specific role.
     *
     * @param string $role
     * @param string $message
     * @param string $url
     */
    public function sendToRole(string $role, string $message, string $url): void
    {
        $users = User::where('role', $role)->get();

        if ($users->isNotEmpty()) {
            Notification::send($users, new GeneralNotification($message, $url));
        }
    }
}
