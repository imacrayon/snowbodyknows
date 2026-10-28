<?php

namespace App\Notifications;

use App\EmailTopic;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WishlistCommentCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Comment $comment
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function shouldSend(User $notifiable): bool
    {
        return EmailTopic::Comments->isSubscribed($notifiable);
    }

    public function toMail(User $notifiable): MailMessage
    {
        return EmailTopic::Comments->mailMessage($notifiable, 'mail.wishlists.comments.create', [
            'comment' => $this->comment,
        ])->subject("{$this->comment->commentable->name} Comment");
    }
}
