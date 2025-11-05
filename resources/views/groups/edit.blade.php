<x-layout.app>
    <x-slot name="title">{{ __('Edit Group') }}</x-slot>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight inline-flex items-center">
            {{ __('Edit :group', ['group' => $group->name]) }}
        </h1>
    </x-slot>
    <div class="max-w-5xl mx-auto px-4 space-y-6 sm:px-6 lg:px-8">
        <div class="p-4 sm:p-8 bg-white shadow-sm rounded-lg">
            <div class="max-w-xl">
                <x-form method="patch" action="{{ route('groups.update', $group) }}">
                    @include('groups._fields')
                    <div class="mt-8 gap-4">
                        <x-button-primary>{{ __('Save changes') }}</x-button-primary>
                        <x-button-secondary href="{{ route('groups.show', $group) }}">{{ __('Cancel') }}</x-button-secondary>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
</x-layout.app>
