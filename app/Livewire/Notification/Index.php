<?php

namespace App\Livewire\Notification;

use App\Models\Notification;
use App\Services\NotificationService;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Notification Center')]
class Index extends Component
{
    use WithPagination;

    public string $filter = 'all'; // 'all', 'unread', 'read'
    public string $typeFilter = '';

    protected $queryString = [
        'filter' => ['except' => 'all'],
    ];

    public function setFilter(string $filter): void
    {
        $this->filter = $filter;
        $this->resetPage();
    }

    public function markAsRead(int $id, NotificationService $service): void
    {
        $service->markRead($id, auth()->id());
        $this->dispatch('notification-updated');
    }

    public function markAllAsRead(NotificationService $service): void
    {
        $count = $service->markAllRead(auth()->id());
        session()->flash('success', "Marked {$count} notification(s) as read.");
        $this->dispatch('notification-updated');
    }

    public function deleteNotification(int $id, NotificationService $service): void
    {
        $service->delete($id, auth()->id());
        session()->flash('success', 'Notification deleted.');
        $this->dispatch('notification-updated');
    }

    public function clearReadNotifications(): void
    {
        $count = Notification::forUser(auth()->id())->read()->delete();
        session()->flash('success', "Cleared {$count} read notification(s).");
        $this->dispatch('notification-updated');
    }

    public function render(NotificationService $service)
    {
        $userId = auth()->id();

        $query = Notification::forUser($userId)->orderBy('created_at', 'desc');

        if ($this->filter === 'unread') {
            $query->unread();
        } elseif ($this->filter === 'read') {
            $query->read();
        }

        if (!empty($this->typeFilter)) {
            $query->where('type', $this->typeFilter);
        }

        $notifications = $query->paginate(15);
        $unreadCount   = $service->getUnreadCount($userId);
        $totalCount    = Notification::forUser($userId)->count();
        $readCount     = Notification::forUser($userId)->read()->count();

        return view('livewire.notification.index', [
            'notifications' => $notifications,
            'unreadCount'   => $unreadCount,
            'totalCount'    => $totalCount,
            'readCount'     => $readCount,
        ])->layout('layouts.app');
    }
}
