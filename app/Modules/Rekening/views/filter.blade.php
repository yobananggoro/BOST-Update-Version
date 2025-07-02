{{ Form::open(['url' => '/rekening/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
<div class="card card-primary collapsed-card">
    <div class="card-header">
        <h3 class="card-title">{{ __('label.filter') }}</h3>
        {!! Html::cardCollapse() !!}
    </div>  
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                {{ Form::fgText('Cif', 'cif', request()->cif, ['class' => 'form-control'], null, 'text', true) }}
            </div>
            <div class="col-md-6">
                {{ Form::fgText('Nama Rekening', 'nama', request()->nama, ['class' => 'form-control'], null, 'text', true) }}
            </div>
        </div>
    </div>
    <div class="card-footer">
        {{ Form::fgFilterButton() }}
    </div>
</div>
{{ Form::close() }}
