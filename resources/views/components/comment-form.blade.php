@props(['action' => '', 'method' => 'post' ,'anonymous' => true, 'comment' => null, 'wishlist' => null])

<div class="relative flex items-start gap-x-2 w-full" id="comment_{{ $comment?->id }}" x-init x-target>
    <img src="{{ $anonymous ? '/img/face.svg' : Auth::user()->avatar_url }}" alt="" width="24" height="24" class="flex-none rounded-full bg-gray-50">
    <x-form method="{{ $method }}" action="{{ $action }}" class="relative flex-auto min-w-min" {{ $attributes }}>
        <div class="overflow-hidden rounded-lg pb-12 shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-blue-600">
            <label for="comment" class="sr-only">Add your comment</label>
            <textarea {{ $anonymous ? 'aria-describedby="comment_description"' : '' }} rows="3" name="comment" id="comment" value="{{ old('comment') }}" class="block w-full resize-none border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Add your comment...">{{ old('comment') ?? $comment?->content }}</textarea>
        </div>
        <div class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
            <div class="flex items-center space-x-5 gap-3">
                @if ($anonymous)
                    <p id="comment_description" class="text-xs text-gray-500 ml-3">{{ __('Your comments will be posted anonymously.') }}</p>
                @endif
                @if ($comment !== null)
                    <div class="flex flex-row justify-end items-center">
                        <a href="{{ route('wishlists.comments.show', ['wishlist' => $wishlist->id, 'comment' => $comment->id]) }}" class="text-xs text-gray-500 mr-2 underline ml-3" x-init x-target="comment_{{ $comment->id }}">Cancel</a>
                        <button class="ml-6 rounded-md bg-white px-2 py-1.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Comment</button>
                    </div>
                @endif
            </div>

        </div>
    </x-form>
</div>