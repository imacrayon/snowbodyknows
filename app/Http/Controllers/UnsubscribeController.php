<?php

namespace App\Http\Controllers;

use App\EmailTopic;
use App\Models\User;
use Illuminate\View\View;

class UnsubscribeController extends Controller
{
    public function show(User $user, EmailTopic $topic): View
    {
        return view('unsubscribe.show', [
            'user' => $user,
            'topic' => $topic,
            'subscribed' => $topic->isSubscribed($user),
        ]);
    }

    public function store(User $user, EmailTopic $topic): View
    {
        $user->update([$topic->preference() => false]);

        return $this->show($user, $topic);
    }
}
