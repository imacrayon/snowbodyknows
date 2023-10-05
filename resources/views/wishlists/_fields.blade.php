<div class="space-y-6">
    <x-field>
        <x-label for="name" :value="__('Name')" />
        <x-error for="name" />
        <x-input name="name" :value="$wishlist->name" required autofocus />
    </x-field>
</div>
