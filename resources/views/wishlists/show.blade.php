<x-app-layout>
<h1>{{ $wishlist->name }}</h1>
<ul>
@foreach($wishes as $wish)
<li>{{ $wish->name }}</></li>
@endforeach
</ul>
<a href="{{ route('wishes.create', $wishlist) }}">Add Wish</a>
</x-app-layout>
