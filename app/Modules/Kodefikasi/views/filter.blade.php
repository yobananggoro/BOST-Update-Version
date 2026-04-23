<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <b>Filter Data</b>
            </div>
            <form action="{{ url('kodefikasi/filter') }}" method="post" role="form" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">Kodefikasi Master</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <select name="groupCode" class="form-control">
                                    <option value="">- Pilih -</option>
                                    @foreach($kodefikasi_group_code as $key => $value)
                                    <option value="{{$key}}" {{$key == @$request->groupCode ? 'selected':'' }}>{{$value}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-info"><i class="fas fa-search"></i> Get List</button>
                    </div>
                    <div class="btn-group">
                        <button type="reset" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>