<x-mail::message>

{{ __(':user added a wish to :wishlist.', [
    'user' => $wish->wishlist->user->name,
    'wishlist' => $wish->wishlist->name
]) }}

<x-mail::panel>
**{{ $wish->name }}**
@if($wish->description)
{{ $wish->decription }}
@endif
</x-mail::panel>

<x-mail::button url="{{ $url = route('wishlists.show', $wish->wishlist) }}">
{{ __('View wishlist') }}
</x-mail::button>

<x-slot:subcopy>
{{ __('You are receiving this because you have joined :wishlist.', ['wishlist' => $wish->wishlist->name]) }}

@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => __('View wishlist'),
    ]
) <span class="break-all">[{{ $url }}]({{ $url }})</span>
</x-slot:subcopy>
</x-mail::message>
