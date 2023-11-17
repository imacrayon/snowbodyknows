<div class="space-y-6">
    <x-field>
        <x-label for="name" :value="__('Event Name')" />
        <x-error for="name" />
        <x-input name="name" :value="$party->name" required autofocus />
    </x-field>
    <x-field>
        <x-label for="description">
            {{ __('Event Description') }}
            <span class="text-gray-600">(optional)</span>
        </x-label>
        <x-error for="description" />
        <x-textarea name="description" :value="$party->description" />
    </x-field>
    @if ($party->use_address_bool == 1)
    <x-field>
        <x-label for="address">
            {{ __('Event Address') }}
            <span class="text-gray-600">(optional)</span>
        </x-label>
        <x-error for="address" />
        <x-input name="address" :value="$party->address" />
    </x-field>
    {{--
    <!-- Add component to search google maps for location to autopopulate the lat/lng below based off of address -->
    <x-field>
        <x-label for="lat" :value="__('Event Latitude')" />
        <x-error for="lat" />
        <x-input name="lat" :value="$party->lat" />
    </x-field>
    <x-field>
        <x-label for="lng" :value="__('Event Longitude')" />
        <x-error for="lng" />
        <x-input name="lng" :value="$party->lng" />
    </x-field>
    --}}
    @endif
    @if ($party->use_dates_bool == 1)
    <x-field class="inline-block">
        <x-label for="start_date">
            {{ __('Event Start Date') }}
            <span class="text-gray-600">(optional)</span>
        </x-label>
        <x-error for="start_date" />
        <x-input name="start_date" :value="$party->start_date" type="date" />
    </x-field>
    <x-field class="inline-block">
        <x-label for="start_time">
            {{ __('Event Start Time') }}
            <span class="text-gray-600">(optional)</span>
        </x-label>
        <x-error for="start_time" />
        <x-input name="start_time" :value="$party->start_time" type="time" />
    </x-field>
    <br />
    <x-field class="inline-block">
        <x-label for="end_date">
            {{ __('Event End Date') }}
            <span class="text-gray-600">(optional)</span>
        </x-label>
        <x-error for="end_date" />
        <x-input name="end_date" :value="$party->end_date" type="date" />
    </x-field>
    <x-field class="inline-block">
        <x-label for="end_time">
            {{ __('Event End Time') }}
            <span class="text-gray-600">(optional)</span>
        </x-label>
        <x-error for="end_time" />
        <x-input name="end_time" :value="$party->end_time" type="time" />
    </x-field>
    @endif
</div>
