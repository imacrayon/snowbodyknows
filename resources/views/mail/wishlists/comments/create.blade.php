<x-mail::message>

{{ __(':user commented on :wishlist.', [
    'user' => $comment->user->is($comment->commentable->user) ? $comment->user->name : __('A viewer'),
    'wishlist' => $comment->commentable->name
]) }}

<x-mail::panel>
{!! Str::markdown($comment->content, ['html_input' => 'strip']) !!}
</x-mail::panel>

<x-mail::button url="{{ $url = route('wishlists.show', $comment->commentable) }}">
{{ __('View wishlist') }}
</x-mail::button>

<x-slot:subcopy>
{{ __('You are receiving this because you have joined :wishlist.', ['wishlist' => $comment->commentable->name]) }}

@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => __('View wishlist'),
    ]
) <span class="break-all">[{{ $url }}]({{ $url }})</span>
</x-slot:subcopy>
</x-mail::message>
