<div class="space-y-6">
    <x-field>
        <x-label for="name" :value="__('Event Name')" />
        <x-error for="name" />
        <x-input name="name" :value="$party->name" required autofocus />
    </x-field>
    <x-field>
        <x-label for="description" :value="__('Event Description')" />
        <x-error for="description" />
        <x-textarea name="description" :value="$party->description" />
    </x-field>
    <x-field>
        <x-label for="address" :value="__('Event Address')" />
        <x-error for="address" />
        <x-input name="address" :value="$party->address" />
    </x-field>
    <div>
        <code>@TODO Add component to search google maps for location to autopopulate the lat/lng below based off of address</code>
    </div>
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
    <div>
        <code>@TODO Possibly split start/end datetimes to separate columns for easier inputs?</code>
    </div>
    <x-field>
        <x-label for="start_date" :value="__('Event Start Date')" />
        <x-error for="start_date" />
        <x-input name="start_date" :value="$party->start_datetime" type="date" />
    </x-field>
    <x-field>
        <x-label for="start_time" :value="__('Event Start Time')" />
        <x-error for="start_time" />
        <x-input name="start_time" :value="$party->start_datetime" type="time" />
    </x-field>
    <x-field>
        <x-label for="end_date" :value="__('Event End Date')" />
        <x-error for="end_date" />
        <x-input name="end_date" :value="$party->end_datetime" type="date" />
    </x-field>
    <x-field>
        <x-label for="end_time" :value="__('Event End Time')" />
        <x-error for="end_time" />
        <x-input name="end_time" :value="$party->end_datetime" type="time" />
    </x-field>
</div>
