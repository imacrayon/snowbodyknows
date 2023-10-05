<x-field>
    <x-label for="name" :value="__('Name')" />
    <x-error for="name" />
    <x-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$wishlist->name" required autofocus />
</x-field>
