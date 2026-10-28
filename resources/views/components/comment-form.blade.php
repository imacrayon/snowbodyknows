@props(['method' => 'post', 'action' => '', 'anonymous' => true, 'comment' => null])

@php($fieldId = $comment ? "comment_{$comment->id}_content" : 'comment')

<div class="relative flex items-start gap-x-3">
    <img src="{{ $anonymous ? '/img/face.svg' : Auth::user()->avatar_url }}" alt="" width="24" height="24" class="flex-none rounded-full bg-gray-50">
    <x-form :method="$method" action="{{ $action }}" class="flex-auto" {{ $attributes }}>
        <div class="relative">
            <div class="overflow-hidden rounded-lg pb-12 shadow-xs ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-blue-600">
                <label for="{{ $fieldId }}" class="sr-only">{{ $comment ? __('Edit your comment') : __('Add your comment') }}</label>
                <textarea x-autofocus @if ($anonymous) aria-describedby="{{ $fieldId }}_description" @endif rows="2" name="comment" id="{{ $fieldId }}" required class="block w-full min-h-16 field-sizing-content resize-none border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Add your comment...">{{ old('comment', $comment?->content) }}</textarea>
            </div>
            <div class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
                <div class="flex items-center space-x-5">
                    @if ($anonymous)
                        <p id="{{ $fieldId }}_description" class="text-xs text-gray-500">{{ __('Your comments will be posted anonymously.') }}</p>
                    @endif
                </div>
                <div class="ml-6 flex items-center gap-x-5">
                    @if ($comment)
                        <a href="{{ route('wishlists.show', $comment->commentable_id) }}" x-target="comment_{{ $comment->id }}" class="text-xs text-gray-500 underline">{{ __('Cancel') }}</a>
                    @endif
                    <button class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-700 shadow-xs ring-1 ring-inset ring-gray-300 hover:bg-gray-50">{{ $comment ? __('Save') : __('Comment') }}</button>
                </div>
            </div>
        </div>
        <x-error for="comment" class="mt-2" />
    </x-form>
</div>
