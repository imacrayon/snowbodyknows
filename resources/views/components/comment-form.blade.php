@props(['action' => '', 'anonymous' => true])

<div class="relative flex items-start gap-x-3">
    <img src="{{ $anonymous ? '/img/face.svg' : Auth::user()->avatar_url }}" alt="" width="24" height="24" class="flex-none rounded-full bg-gray-50">
    <x-form method="post" action="{{ $action }}" class="relative flex-auto" {{ $attributes }}>
        <div class="overflow-hidden rounded-lg pb-12 shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-blue-600">
            <label for="comment" class="sr-only">Add your comment</label>
            <textarea {{ $anonymous ? 'aria-describedby="comment_description"' : '' }} rows="2" name="comment" id="comment" value="{{ old('comment') }}" class="block w-full resize-none border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Add your comment..."></textarea>
        </div>
        <div class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
            <div class="flex items-center space-x-5">
                @if ($anonymous)
                    <p id="comment_description" class="text-xs text-gray-500">{{ __('Your comments will be posted anonymously.') }}</p>
                @endif
            </div>
            <button class="ml-6 rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Comment</button>
        </div>
    </x-form>
</div>
