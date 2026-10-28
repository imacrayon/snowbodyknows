<x-mail::message>

{{ trans_choice(':user added a wish to :wishlist.|:user added :count wishes to :wishlist.', $wishes->count(), [
    'user' => $wishlist->user->name,
    'wishlist' => $wishlist->name
]) }}

<x-mail::panel>
@foreach ($wishes as $wish)
**{{ $wish->name }}**

@if($wish->description)
{{ $wish->description }}

@endif
@endforeach
</x-mail::panel>

<x-mail::button url="{{ $url = route('wishlists.show', $wishlist) }}">
{{ __('View wishlist') }}
</x-mail::button>

<x-slot:subcopy>
{{ __('You are receiving this because you have joined :wishlist.', ['wishlist' => $wishlist->name]) }}
@include('mail.partials.unsubscribe')

@lang(
    "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser:',
    [
        'actionText' => __('View wishlist'),
    ]
) <span class="break-all">[{{ $url }}]({{ $url }})</span>
</x-slot:subcopy>
</x-mail::message>
