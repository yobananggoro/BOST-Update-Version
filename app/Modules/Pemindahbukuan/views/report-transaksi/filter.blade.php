<div class="row">
    <div class="col-6">
        <div class="card card-default">
            <div class="card-header">
                <div class="btn-group">
                    <b>Filter</b>
                </div>
            </div>
            <form action="{{ url('report-transaksi/getReport') }}" method="post" id="formInput" class="form-horizontal">
                @csrf
                <div class="card-body">
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">Tanggal</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" id="startDate" name="startDate" value="{{@$request->startDate}}" onchange="getRequest(this)" class="form-control datepick" placeholder="Start Date">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" id="endDate" name="endDate" value="{{@$request->endDate}}" onchange="getRequest(this)" class="form-control datepick" placeholder="End Date">
                            </div>
                        </div>
                    </div>
                    @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">User ID</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('userid', @$request->userid)}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">Branch</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <select name="branch" id="branch" class="form-control select2" style="width: 100%;" onchange="getRequest(this)">
                                    <option value="">- Pilih -</option>
                                    @foreach($branch as $key => $value)
                                    <option value="{{$value['kode']}}" {{$value['kode'] == $request->branch ? 'selected':'' }}>{{$value['nama']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">User ID</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                @if(auth()->user()->profile->rolename != "Operator")
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{ old('userid', @$request->userid) }}">
                                @else
                                <input type="text" id="userid" name="userid" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{ auth()->user()->username }}" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">Branch</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" maxlength="4" value="{{auth()->user()->profile->unitKerja->nama}}" readonly>
                                <div style="display: none">
                                    <input type="hidden" id="branch" name="branch" class="form-control" maxlength="4" value="{{auth()->user()->profile->unit_kerja_kode}}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <button type="submit" id="btnEnter" class="btn btn-sm btn-info"><i class="fas fa-search"></i> Filter</button>
                    </div>
                    <div class="btn-group">
                        <a href="{{url('report-transaksi')}}" type="button" id="btnEnter" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                    <div class="btn-group float-right">
                        @if(@$request->userid != '')
                        <button id="btnPrintPDF" class="btn btn-sm btn-success" form="formPdf"><i class="fas fa-print"></i> Export PDF</button>
                        @endif
                    </div>
                </div>
            </form>
            <form action="{{ url('report-transaksi/pdf') }}" method="post" target="_blank" id="formPdf" class="form-horizontal">
                @csrf
                <input type="hidden" id="startDate_" name="startDate" value="{{@$request->startDate}}" readonly>
                <input type="hidden" id="endDate_" name="endDate" value="{{@$request->endDate}}" readonly>
                <input type="hidden" id="userID_" name="userid" maxlength="4" value="{{ @$request->userid }}" readonly>
                @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                <input type="hidden" id="branch_" name="branch" maxlength="4" value="{{@$request->branch}}" readonly>
                @else
                <input type="hidden" id="branch_" name="branch" maxlength="4" value="{{auth()->user()->profile->unit_kerja_kode}}" readonly>
                @endif

            </form>
        </div>
    </div>
</div>