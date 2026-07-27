<?php

namespace App\Notifications;

use App\Models\Summary;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SummaryReadyNotification extends Notification
{
    use Queueable;

    public function __construct(public Summary $summary)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'summary_id' => $this->summary->id,
            'course_id' => $this->summary->course_id,
            'title' => 'Summary Ready ✨',
            'message' => "Academic AI summary for \"{$this->summary->title}\" is ready to view & download.",
            'status' => 'completed',
        ];
    }
}
