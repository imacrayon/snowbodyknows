<div class="space-y-6">
    <x-field>
        <x-label for="name" :value="__('Item name')" />
        <x-error for="name" />
        <x-input name="name" :value="$wish->name" required autofocus />
    </x-field>
    <x-field>
        <x-label for="url" :value="__('URL')" />
        <x-error for="url" />
        <x-input name="url" :value="$wish->url" placeholder="https://..." />
    </x-field>
    <x-field>
        <x-label for="description" :value="__('Notes')" />
        <x-error for="description" />
        <x-input name="description" :value="$wish->description" placeholder="Size, color, quantity, etc." />
    </x-field>
</div>
