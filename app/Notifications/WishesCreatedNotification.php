<?php

namespace App\Notifications;

use App\EmailTopic;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\Attributes\WithoutRelations;

class WishesCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        #[WithoutRelations]
        public Wishlist $wishlist,
        public Collection $wishes
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function shouldSend(User $notifiable): bool
    {
        return EmailTopic::Wishes->isSubscribed($notifiable);
    }

    public function toMail(User $notifiable): MailMessage
    {
        return EmailTopic::Wishes->mailMessage($notifiable, 'mail.wishes.create', [
            'wishlist' => $this->wishlist,
            'wishes' => $this->wishes,
        ])->subject(trans_choice('{1} Wish added to :wishlist|[2,*] :count wishes added to :wishlist', $this->wishes->count(), [
            'wishlist' => $this->wishlist->name,
        ]));
    }
}
