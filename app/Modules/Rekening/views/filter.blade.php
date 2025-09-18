<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <b>Filter</b>
            </div>
            {{ Form::open(['url' => '/rekening/filter', 'method' => 'post', 'class' => 'form-horizontal form-filter', 'role' => 'form', 'autocomplete' => 'off']) }}
            <div class="card-body">
                <div class="form-group col-12 row">
                    <label class="col-sm-3 col-form-label">Cif</label>
                    <div class="col-sm-3">
                        <div class="input-group">
                            <input type="text" id="cif" name="cif" class="form-control ucase" maxlength="6" value="{{old('cif', @$request->cif)}}">
                        </div>
                    </div>
                </div>
                <div class="form-group col-12 row">
                    <label class="col-sm-3 col-form-label">Nama Rekening</label>
                    <div class="col-sm-9">
                        <div class="input-group">
                            <input type="text" id="nama" name="nama" class="form-control" value="{{old('nama', @$request->nama)}}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                {{ Form::fgFilterButton() }}
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>