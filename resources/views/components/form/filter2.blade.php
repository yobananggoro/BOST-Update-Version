<button class="btn btn-primary btn-sm">
    <i class="fa fa-search"></i> {{ __('button.filter') }}
</button>&nbsp;
@php
$path = request()->segment(1);
@endphp
<a href="{{url($path)}}" class="btn btn-warning btn-sm">
    <i class="fa fa-redo"></i> {{ __('button.reset') }}
</a>