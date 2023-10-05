<x-app-layout>
<ul>
@foreach($wishlists as $wishlist)
<li><a class="underline" href="{{ route('wishlists.show', $wishlist) }}">{{ $wishlist->name }}</a></li>
@endforeach
</ul>
</x-app-layout>
