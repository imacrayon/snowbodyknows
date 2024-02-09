@props(['comment', 'anonymous' => true])

<div id="comment_{{ $comment->id }}" class="relative flex items-start gap-x-2 pb-2 w-full">
    <div class="absolute left-0 top-3 h-full flex w-6 justify-center">
        <div class="w-px bg-gray-200"></div>
    </div>
    <img src="{{ $anonymous ? '/img/face.svg' : $comment->user->avatar_url }}" alt="" width="24" height="24" class="relative mt-3 flex-none rounded-full bg-gray-50">
    <div class="flex-auto rounded-md p-2 ring-1 ring-inset ring-gray-200">
        <div class="py-0.5 text-xs leading-5 text-gray-500">
            @if($anonymous)
                <span class="font-medium text-gray-900">{{ __('A viewer') }}</span> {{ __('commented') }} <x-time :datetime="$comment->created_at" class="flex-none py-0.5 text-xs leading-5 text-gray-500" />
            @else
                <span class="font-medium text-gray-900">{{ $comment->user->name }}</span> {{ __('commented') }} <x-time :datetime="$comment->created_at" class="flex-none py-0.5 text-xs leading-5 text-gray-500" />
            @endif
        </div>
        <div class="prose prose-sm">{!! Str::markdown($comment->content, ['html_input' => 'strip']) !!}</p>
        @can('delete', $comment)
            <div class="mt-2 flex items-center justify-end gap-x-5">
                <a class="text-xs text-gray-500 mr-2 mt-1 underline" href="{{ route('wishlists.comments.edit', ['wishlist' => $comment->commentable_id, 'comment' => $comment->id]) }}" x-init x-target="comment_{{ $comment->id }}">Edit</a>
                <x-form method="delete" action="{{ route('wishlists.comments.destroy', [$comment->commentable_id, $comment->id]) }}" x-target="comment_{{ $comment->id }}" x-on:ajax:before="confirm('{{ __('This comment will be permanently deleted.') }}') || $event.preventDefault()">
                    <button class="text-xs text-gray-500 underline">Delete</button>
                </x-form>
            </div>
        @endif

    </div>
</div>
