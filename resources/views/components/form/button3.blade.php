<button class="btn btn-primary btn-sm save-close">
    <i class="fa fa-backward"></i> {{ __('button.save_close') }}
</button>&nbsp;
<a href="{{ route((\Str::contains($uri, '.') ? $uri : $uri . '.index'), $parameter) }}" class="btn btn-danger btn-sm" rel="content">
    <i class="fa fa-times"></i> {{ __('button.cancel2') }}
</a>
