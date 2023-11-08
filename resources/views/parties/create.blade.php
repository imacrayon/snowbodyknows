<x-app-layout>
    <x-slot name="title">
        {{ __('New Party') }}
    </x-slot>
    <x-slot name="header">
        <x-back href="{{ route('parties.index') }}">{{ __('Parties') }}</x-back>
        <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('New party') }}
        </h1>
    </x-slot>
    <div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 bg-white shadow rounded-lg">
            <div class="max-w-xl">
                <x-form method="post" action="{{ route('parties.store', $party) }}">
                    @include('parties._fields')
                    <x-button-primary class="mt-8">{{ __('Create party') }}</x-button-primary>
                </x-form>
            </div>
        </div>
    </div>
</x-app-layout>
