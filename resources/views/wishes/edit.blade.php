<x-app-layout>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        Edit wish
    </h1>
</x-slot>
<div class="py-12">
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <x-form method="patch" action="{{ route('wishes.update', [$wishlist, $wish]) }}">
                @include('wishes._fields')
                <x-button-primary class="mt-8">Save changes</x-button-primary>
            </x-form>
        </div>
    </div>
</div>
</x-app-layout>
