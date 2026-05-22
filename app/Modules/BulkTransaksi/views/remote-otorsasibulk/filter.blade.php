<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <b>Filter</b>
            </div>
            <form action="{{ url('remote-otorisasibulk/filter') }}" method="post" role="form" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <input type="hidden" name="status_bulk" value="VERIFIED_AND_WAITING_APPROVAL">
                    @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">UserID Maker</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('userid', @$request->userid)}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">Branch</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <select name="branch" class="form-control select2" style="width: 100%">
                                    <option value="">- Pilih -</option>
                                    @foreach($branch as $key => $value)
                                    {{-- <option value="">{{$value['nama']}}</option> --}}
                                    <option value="{{$value['kode']}}" {{$value['kode'] == $request->branch ? 'selected':'' }}>{{$value['nama']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">UserID Maker</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                @if(!in_array(auth()->user()->profile->rolename, ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional']))
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('userid', @$request->userid)}}">
                                @else
                                <input type="text" id="userID" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{auth()->user()->username}}" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">Branch</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <select class="form-control select2" style="width: 100%" disabled >
                                    @foreach($branch as $key => $value)
                                    {{-- <option value="">{{$value['nama']}}</option> --}}
                                    <option value="{{$value['kode']}}" {{$value['kode'] == auth()->user()->profile->unit_kerja_kode ? 'selected':'' }}>{{$value['nama']}}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="branch" value="{{auth()->user()->profile->unit_kerja_kode}}">
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
                        <a href="{{url('remote-otorisasibulk')}}" type="button" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>