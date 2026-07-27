<?php

namespace App\Notifications;

use App\Models\CourseMaterial;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SummaryFailedNotification extends Notification
{
    use Queueable;

    public function __construct(public CourseMaterial $material, public string $reason)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'material_id' => $this->material->id,
            'title' => 'Summary Generation Failed',
            'message' => "Failed to process \"{$this->material->title}\": {$this->reason}",
            'status' => 'failed',
        ];
    }
}
