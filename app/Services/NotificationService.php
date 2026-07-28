<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class NotificationService
{
    /**
     * Send an in-app notification to a user.
     *
     * @param User|int $user User model or user ID
     * @param string $type One of Notification::TYPE_*
     * @param string $title Notification title
     * @param string $message Main message body
     * @param string|null $actionUrl Optional URL to navigate to when clicked
     * @param array $data Additional JSON metadata
     * @param int|null $courseId Associated course ID if applicable
     */
    public function send(
        User|int $user,
        string $type,
        string $title,
        string $message,
        ?string $actionUrl = null,
        array $data = [],
        ?int $courseId = null
    ): Notification {
        $userId = $user instanceof User ? $user->id : $user;

        return Notification::create([
            'user_id'      => $userId,
            'course_id'    => $courseId,
            'title'        => $title,
            'message'      => $message,
            'type'         => $type,
            'action_url'   => $actionUrl,
            'data'         => $data,
            'scheduled_at' => now(),
            'sent_at'      => now(),
            'is_read'      => false,
        ]);
    }

    /**
     * Mark a specific notification as read.
     */
    public function markRead(int $id, ?int $userId = null): bool
    {
        $query = Notification::where('id', $id);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return (bool) $query->update(['is_read' => true]);
    }

    /**
     * Mark all unread notifications as read for a user.
     */
    public function markAllRead(?int $userId = null): int
    {
        $targetUserId = $userId ?? auth()->id();

        if (!$targetUserId) {
            return 0;
        }

        return Notification::forUser($targetUserId)
            ->unread()
            ->update(['is_read' => true]);
    }

    /**
     * Delete a specific notification.
     */
    public function delete(int $id, ?int $userId = null): bool
    {
        $query = Notification::where('id', $id);

        if ($userId) {
            $query->where('user_id', $userId);
        }

        return (bool) $query->delete();
    }

    /**
     * Get unread count for a user.
     */
    public function getUnreadCount(?int $userId = null): int
    {
        $targetUserId = $userId ?? auth()->id();

        if (!$targetUserId) {
            return 0;
        }

        return Notification::forUser($targetUserId)->unread()->count();
    }

    /**
     * Get recent notifications for a user (top 5 for topbar & widgets).
     */
    public function getRecent(?int $userId = null, int $limit = 5): Collection
    {
        $targetUserId = $userId ?? auth()->id();

        if (!$targetUserId) {
            return new Collection();
        }

        return Notification::forUser($targetUserId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
