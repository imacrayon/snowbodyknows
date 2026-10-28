<x-layout.marketing>
<x-slot name="title">{{ __('Privacy Policy') }}</x-slot>
<div class="max-w-6xl mx-auto">
<div class="prose max-w-prose py-12">
    {!! Str::markdown(file_get_contents(resource_path('markdown/privacy.md'))) !!}
</div>
</div>
</x-layout.marketing>
