<div class="space-y-6">
    <x-field>
        <x-label for="name" :value="__('Group Name')" />
        <x-error for="name" />
        <x-input name="name" :value="$group->name" required autofocus />
    </x-field>
    <x-field>
        <x-label for="description">
            {{ __('Description') }}
            <span class="text-gray-600">(optional)</span>
        </x-label>
        <x-error for="description" />
        <x-description for="description" value="{{ __('Include a group message or details about your gift exchange.') }}" />
        <x-textarea name="description" :value="$group->description" aria-describedby="description_description" />
    </x-field>
</div>
