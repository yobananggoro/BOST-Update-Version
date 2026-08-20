<div class="row">
    <div class="col-7">
        <div class="card card-default">
            <div class="card-header">
                <b>Filter</b>
            </div>
            <form action="{{ url('report-bulkupload/filter') }}" method="post" id="mainForm" role="form" class="form-horizontal">
                @csrf
                <div class="card-body">
                    @if(auth()->user()->profile->rolename == "SUPER ADMIN")
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">UserID Operator</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="createdBy" name="createdBy" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('createdBy', @$request->createdBy)}}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">UserID Penyelia</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" id="updatedBy" name="updatedBy" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('updatedBy', @$request->updatedBy)}}">
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
                                    <option value="{{$value['kode']}}" {{$value['kode'] == $request->branch ? 'selected':'' }}>{{$value['nama']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">Tanggal Transaksi</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" id="startDate" name="startDate" value="{{@$request->startDate}}" class="form-control datepick" placeholder="Start Date">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" id="endDate" name="endDate" value="{{@$request->endDate}}" class="form-control datepick" placeholder="End Date">
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">UserID Operator</label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                @if(!in_array(auth()->user()->profile->rolename, ['Operator']))
                                <input type="text" id="createdBy" name="createdBy" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{old('createdBy', @$request->createdBy)}}">
                                @else
                                <input type="text" id="createdBy" name="createdBy" class="form-control ucase" onchange="getRequest(this)" maxlength="4" value="{{auth()->user()->username}}" readonly>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-12 row">
                        <label class="col-sm-4 col-form-label">Branch</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <select class="form-control select2" style="width: 100%" disabled>
                                    @foreach($branch as $key => $value)
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
                        <a href="{{url('report-bulkupload')}}" type="button" class="btn btn-sm btn-danger"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                    <div class="btn-group float-right">
                        <button id="btnPrintPDF" class="btn btn-sm btn-success"><i class="fas fa-print"></i> Export PDF</button>
                    </div>
                </div>
            </form>
            <script>
                const exportUrl = "{{ url('report-bulkupload/export') }}";
                const mainUrl = "{{ url('report-bulkupload/filter') }}";
            </script>
        </div>
    </div>
</div>