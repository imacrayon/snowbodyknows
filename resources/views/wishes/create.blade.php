<x-app-layout>
<x-form method="post" action="{{ route('wishes.store', $wishlist) }}">
    @include('wishes._fields')
    <x-button-primary class="mt-8">Save changes</x-button-primary>
</x-form>
</x-app-layout>
