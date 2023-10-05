@props(['method' => 'get', 'action' => '', 'upload' => false])

<form method="{{ $method !== 'get' ? 'post' : 'get' }}" action="{{ $action }}" {!! $upload ? 'enctype="multipart/form-data"' : '' !!} {{ $attributes }}>
    @csrf
    @method($method)
    {{ $slot }}
</form>
