<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <b>Filter Data</b>
            </div>
            <form action="{{ url('transaksi-list/filter') }}" method="post" role="form" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Status Override</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <select name="status_override" class="form-control">
                                    <option value="">- Pilih -</option>
                                    @foreach($status_approval as $key => $value)
                                    <option value="{{$key}}" {{$key == $request->status_override ? 'selected':'' }}>{{$value}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Nama Transaksi</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <select name="tipe_transaksi" class="form-control">
                                    <option value="">- Pilih -</option>
                                    @foreach($tipe_transaksi as $key => $value)
                                    <option value="{{$key}}" {{$key == $request->tipe_transaksi ? 'selected':'' }}>{{$value}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                    <!-- <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">User Maker</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('userid', @$request->userid)}}">
                            </div>
                        </div>
                    </div> -->
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Nomor Refference</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="noReff" name="reff" class="form-control ucase" value="{{old('reff', @$request->reff)}}">
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">User Maker</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('userid', @$request->userid)}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-3 col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <select name="branch" class="form-control select2">
                                    <option value="">- Pilih -</option>
                                    @foreach($branch as $key => $value)
                                    {{-- <option value="">{{$value['nama']}}</option> --}}
                                    <option value="{{$value['kode']}}" {{$value['kode'] == $request->branch ? 'selected':'' }}>{{$value['nama']}}</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button class="btn btn-sm btn-info"><i class="fas fa-search"></i> Filter</button>
                    </div>
                    <div class="btn-group">
                        <a href="{{url('transaksi-list')}}" type="button" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>