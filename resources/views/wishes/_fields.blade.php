<x-field>
    <x-label for="name" :value="__('Item name')" />
    <x-error for="name" />
    <x-input name="name" :value="$wish->name" required autofocus />
</x-field>
<x-field>
    <x-label for="description" :value="__('Description')" />
    <x-error for="description" />
    <x-input name="description" :value="$wish->description" placeholder="Size, color, quantity, etc." />
</x-field>
