<?php

namespace App;

use App\Models\User;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\URL;
use Symfony\Component\Mime\Email;

enum EmailTopic: string
{
    case Wishes = 'wishes';
    case Comments = 'comments';

    public function preference(): string
    {
        return match ($this) {
            self::Wishes => 'receives_wish_emails',
            self::Comments => 'receives_comment_emails',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::Wishes => __('new wishes'),
            self::Comments => __('new comments'),
        };
    }

    public function isSubscribed(User $user): bool
    {
        return $user->getAttribute($this->preference());
    }

    public function unsubscribeUrl(User $user): string
    {
        return URL::signedRoute('unsubscribe.show', ['user' => $user, 'topic' => $this]);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function mailMessage(User $user, string $view, array $data): MailMessage
    {
        $unsubscribeUrl = $this->unsubscribeUrl($user);

        return (new MailMessage)
            ->markdown($view, $data + ['topic' => $this, 'unsubscribeUrl' => $unsubscribeUrl])
            ->withSymfonyMessage(fn (Email $message) => $message->getHeaders()
                ->addTextHeader('List-Unsubscribe', "<{$unsubscribeUrl}>")
                ->addTextHeader('List-Unsubscribe-Post', 'List-Unsubscribe=One-Click'));
    }
}
