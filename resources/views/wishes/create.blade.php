<x-app-layout>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        Add to {{ $wishlist->name }}
    </h1>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                <x-form method="post" action="{{ route('wishes.store', $wishlist) }}">
                    @include('wishes._fields')
                    <x-button-primary class="mt-8">Save changes</x-button-primary>
                </x-form>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
