<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PromotionNotification extends Notification
{
    use Queueable;

    public $title;
    public $message;
    public $url;
    public $image;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $url = null, $image = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->url = $url;
        $this->image = $image;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database']; // only save to database for bell icon
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'url' => $this->url,
            'image' => $this->image,
            'type' => 'promotion'
        ];
    }
}
