<?php

namespace App\Notifications;

use App\Models\Wish;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WishCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Wish $wish
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Wish added to {$this->wish->wishlist->name}")
            ->markdown('mail.wishes.create', ['wish' => $this->wish]);
    }
}
