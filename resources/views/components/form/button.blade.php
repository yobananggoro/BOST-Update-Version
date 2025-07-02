@if($action === 'create')
    <button class="btn btn-success btn-sm save">
        <i class="fa fa-save"></i> {{ __('button.save') }}
    </button>&nbsp;
@endif
<button class="btn btn-primary btn-sm save-close">
    <i class="fa fa-backward"></i> {{ __('button.save_close') }}
</button>&nbsp;
{{-- <button type="reset" class="btn btn-warning btn-sm reset">
    <i class="fa fa-redo"></i> {{ __('button.reset') }}
</button>&nbsp; --}}
<a href="{{ route((\Str::contains($uri, '.') ? $uri : $uri . '.index'), $parameter) }}" class="btn btn-danger btn-sm" rel="content">
    <i class="fa fa-times"></i> {{ __('button.cancel') }}
</a>