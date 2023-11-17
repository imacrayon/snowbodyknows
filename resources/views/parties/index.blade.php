<x-app-layout>
<x-slot name="title">
    {{ __('Parties') }}
</x-slot>
<x-slot name="header">
    <h1 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Parties') }}
    </h1>
</x-slot>
<div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
    <x-section>
        <x-slot:title>
            {{ __('Your Parties') }}
        </x-slot:title>
        <x-slot:actions>
            <a href="{{ route('parties.create') }}" class="group inline-flex items-center text-sm text-gray-600 font-medium hover:text-sky-600">
                <x-phosphor-plus-circle-fill aria-hidden="true" width="16" height="16" class="mr-1.5 text-gray-400 group-hover:text-sky-400" />
                {{ __('New party') }}
            </a>
        </x-slot:actions>
        <x-slot:description>
            {{ __('Parties that you own. You can invite people to view these.') }}
        </x-slot:description>
        <ul class="divide-y">
            @foreach($parties as $party)
                <li class="block">
                    <a class="flex items-center justify-between gap-6 px-4 py-3 sm:py-4" href="{{ route('parties.show', $party) }}">
                        <div>
                            {{ $party->name }}
                            <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                {{ $party->participants_count }} {{ trans_choice('participant|participants', $party->participants_count) }}
                            </div>
                        </div>
                        <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                    </a>
                </li>
            @endforeach
        </ul>
    </x-section>

    @if($joinedParties->isNotEmpty())
        <x-section>
            <x-slot:title>
                {{ __('Joined Parties') }}
            </x-slot:title>
            <x-slot:description class="mt-2 text-xs text-gray-600">
                {{ __('Parties that have been shared with you. Grant wishes for your friends and family.') }}
            </x-slot:description>
            <ul class="divide-y">
                @foreach($joinedParties as $party)
                    <li class="block">
                        <a class="flex items-center justify-between gap-6 px-4 py-3 sm:py-4" href="{{ route('parties.show', $party) }}">
                            <div>
                                {{ $party->name }}
                                <div class="flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                    {{ $party->wishes_count }} {{ trans_choice('wish|wishes', $party->wishes_count) }}
                                    <svg viewBox="0 0 2 2" aria-hidden="true" class="h-0.5 w-0.5 fill-current"><circle cx="1" cy="1" r="1"></circle></svg>
                                    {{ $party->participants_count }} {{ trans_choice('participant|participants', $party->participants_count) }}
                                </div>
                            </div>
                            <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-section>
    @endif
</div>
</x-app-layout>
