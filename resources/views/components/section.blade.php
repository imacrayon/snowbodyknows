<section>
    <h2 class="text-base font-medium text-gray-900">
        {{ $title }}
    </h2>
    <div class="mt-2 bg-white shadow overflow-hidden rounded-lg">
        {{ $slot }}
    </div>
    @if($description)
        <p class="mt-2 text-xs text-gray-600">
            {{ $description }}
        </p>
    @endif
</section>
