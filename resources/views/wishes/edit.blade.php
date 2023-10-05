<x-app-layout>
<x-form method="patch" action="{{ route('wishes.update', $wish) }}">
    @include('wish._fields')
    <x-button-primary class="mt-8">Save changes</x-button-primary>
</x-form>
</x-app-layout>
