<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Wishlist;
use App\Notifications\WishesCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\Attributes\DebounceFor;
use Illuminate\Queue\Attributes\DeleteWhenMissingModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

#[DebounceFor(600, maxWait: 3600)]
#[DeleteWhenMissingModels]
class NotifyViewersOfNewWishes implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Wishlist $wishlist
    ) {}

    public function debounceId(): string
    {
        return (string) $this->wishlist->id;
    }

    public function handle(): void
    {
        if ($this->wishlist->trashed()) {
            return;
        }

        $wishes = DB::transaction(function () {
            $wishes = $this->wishlist->wishes()->where('notify_viewers', true)->orderBy('order')->lockForUpdate()->get();

            $this->wishlist->wishes()->whereKey($wishes->modelKeys())->update(['notify_viewers' => false]);

            return $wishes;
        });

        if ($wishes->isEmpty()) {
            return;
        }

        $viewers = $this->wishlist->viewers()->reject(fn (User $viewer) => $viewer->is($this->wishlist->user));

        Notification::send($viewers, new WishesCreatedNotification($this->wishlist, $wishes));
    }
}
