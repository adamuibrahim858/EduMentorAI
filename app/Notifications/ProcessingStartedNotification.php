<?php

namespace App\Notifications;

use App\Models\CourseMaterial;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProcessingStartedNotification extends Notification
{
    use Queueable;

    public function __construct(public CourseMaterial $material)
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
            'title' => 'Processing Started',
            'message' => "Extracted text and AI analysis started for \"{$this->material->title}\".",
            'status' => 'processing',
        ];
    }
}
