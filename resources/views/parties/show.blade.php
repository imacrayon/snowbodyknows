<x-app-layout>
<x-slot name="title">
    {{ $party->name }}
</x-slot>
<x-slot name="header">
    <x-back href="{{ route('parties.index') }}">{{ __('Parties') }}</x-back>
    <h1 class="flex items-center gap-2 font-semibold text-xl text-gray-800 leading-tight">
        {{ $party->name }}
        <a class="pl-2" href="{{ route('parties.edit', $party) }}">
            <x-phosphor-pencil aria-hidden="true" width="24" height="24"  class="text-gray-400 hover:text-gray-500" />
            <span class="sr-only">Edit</span>
        </a>
    </h1>
    @if($party->description)
    <p class="text-gray-700 leading-tight pt-3">
        {{ $party->description }}
    </p>
    @endif
    @if ($party->use_address_bool == 1)
        @if($party->address)
        <p class="text-gray-700 leading-tight pt-3">
            <b>Address:</b> {{ $party->address }}
        </p>
        @endif
    @endif
    @if ($party->use_dates_bool == 1)
        @if($party->start_date)
        <p class="text-gray-700 leading-tight">
            <b>Start:</b> {{ $party->start_date->format("F j, Y") }}
            @if($party->start_time)
                {{ $party->start_time->format("g:i a") }}
            @endif
        </p>
        @endif
        @if($party->end_date)
        <p class="text-gray-700 leading-tight">
            <b>End:</b> {{ $party->end_date->format("F j, Y") }}
            @if($party->end_time)
                {{ $party->end_time->format("g:i a") }}
            @endif
        </p>
        @endif
    @endif
</x-slot>
<div class="max-w-7xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">

    <x-section>
        <x-slot:title>
            {{ __('Share') }}
        </x-slot:title>
        <x-slot:description class="mt-1 text-sm text-gray-600">
            {{ __('Use this link to share your party with others.') }}
        </x-slot:description>
        <div x-data="{
            canCopy: window.navigator.clipboard,
            copied: false,
            select() {
                this.$refs.input.setSelectionRange(0, this.$refs.input.value.length)
            },
            copy() {
                window.navigator.clipboard.writeText(this.$refs.input.value)
                this.copied = true
                window.setTimeout(() => this.copied = false, 2000)
            }
        }" class="p-1 flex space-x-1 rounded-md sm:p-4">
            <div class="flex-1">
                <label for="share_url" class="sr-only">{{ __('Share URL') }}</label>
                <input type="url" id="share_url" x-ref="input" readonly x-on:focus="select" value="{{ route('parties.participants.create', $party) }}" x-bind:class="canCopy ? '' : 'rounded-r-md'" class="block w-full rounded-md border-transparent py-1.5 text-gray-900 bg-gray-50 focus:ring-2 focus:ring-inset focus:ring-sky-600 sm:text-sm sm:leading-6">
            </div>
            <button type="button" x-show="canCopy" x-on:click="copy" class="bg-sky-50 relative -ml-px inline-flex items-center gap-x-1.5 rounded-md px-3 py-2 text-sm font-semibold text-sky-800 hover:bg-sky-200 hover:text-sky-900">
                <span x-show="!copied" class="flex items-center">
                    <x-phosphor-copy aria-hidden="true" width="20" height="20" class="-ml-1 mr-2" />
                    Copy
                </span>
                <span x-show="copied" class="flex items-center">
                    <x-phosphor-check aria-hidden="true" width="20" height="20" class="-ml-1 mr-2" />
                    Copied
                </span>
            </button>
        </div>
    </x-section>

    @if ($party->participants->isNotEmpty())
        <x-section>
            <x-slot:title>
                {{ __('Participants') }}
            </x-slot:title>
            <x-slot:description>
                {{ __('These are the people who can view your party.') }}
            </x-slot:descripti>
            <ul id="participants" x-init class="divide-y">
                @foreach($party->participants as $participant)
                    <li class="flex gap-6 px-4 py-3 sm:py-4">
                        <div class="flex-1 flex items-center space-x-2">
                            <img src="{{ $participant->avatar_url }}" width="32" height="32" class="rounded-full" alt="">
                            <div class="flex-1">{{ $participant->name }}
                                @if ($participant->user == request()->user)
                                (You)
                                @endif
                            </div>
                        </div>
                        <x-form class="flex items-center" x-target="participants" method="delete" action="{{ route('parties.participants.destroy', [$party, $participant]) }}" x-on:ajax:before="confirm(`{{ __(':participant will no longer be able to see your party.', ['participant' => $participant->name]) }}`) || $event.preventDefault()">
                            <button class="rounded-full">
                                <x-phosphor-x-circle aria-hidden="true" width="24" height="24" class="text-gray-400 hover:text-red-500" />
                                <span class="sr-only">Remove</span>
                            </button>
                        </x-form>
                    </li>
                    
                    @foreach($party->wishlists as $wishlist)
                        @if ($wishlist->user->id == $participant->id)
                        <li class="flex gap-6 px-12 py-3 sm:py-4">
                            <div class="flex-1 flex items-center space-x-2">
                                <a href="{{ route('wishlists.show', $wishlist) }}">
                                    {{ $wishlist->name }}
                                    <span class="absolute inset-0" aria-hidden="true"></span>
                                </a>
                            </div>
                            <x-phosphor-caret-right aria-hidden="true" width="20" height="20"  class="text-gray-400" />
                        </li>
                        @endif
                    @endforeach
                @endforeach
            </ul>
        </x-section>
    @endif
</div>
</x-app-layout>
