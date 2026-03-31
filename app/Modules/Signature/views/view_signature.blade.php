@extends('layouts.app')
@section('title', 'View Signature')
@section('content')
<div class="row toastrDefaultInfo"></div>
<div class="row toastrDefaultError"></div>
<div class="col-5">
    <!-- <div> -->
    <div class="card card-default" style="display:inline-block; width: 100%">
        <form action="{{ url('view-signature/checkImage') }}" method="post" id="formAccount" role="form" class="form-horizontal">
            @csrf
            <div class="card-body">
                <input type="hidden" name="accuse" id="accuse" value="external" readonly>
                <input type="hidden" name="cif_cust" id="cif_cust" value="{{@$request->cif_cust}}" readonly>
                <input type="hidden" name="cif_name" id="cif_name" value="{{@$request->cif_name}}" readonly>
                <input type="hidden" name="cif_type" id="cif_type" value="{{@$request->cif_type}}" readonly>
                <div class="col-sm-12">
                    <label>Account <span style="color: red">*</span></label>
                    <div class="row">
                        <div class="col-sm-10">
                            <div class="row col-sm-12">
                                <input type="text" name="ext" id="ext" class="form-control number" value="{{@$request->ext}}" maxlength="13" placeholder="External Account">
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="text" name="branch" id="branch" class="form-control number" value="{{@$request->branch}}" maxlength="4" placeholder="Branch">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="cif" id="cif" class="form-control ucase" value="{{@$request->cif}}" maxlength="6" placeholder="CIF">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" name="suffix" id="suffix" class="form-control number" value="{{@$request->suffix}}" maxlength="3" placeholder="Suffix">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-info" onclick="detail();"><i class="fa fa-info-circle"></i> Detail</button>
                        </div>
                    </div>

                    <fieldset style="background-color: #eeeeee; padding: 2px; margin-top: 20px">
                        <table style="margin-left: 20px">
                            <tr>
                                <td style="width: 130px">Customer</td>
                                <td style="width: 10px; display: block">:</td>
                                <td id="cust"></td>
                            </tr>
                            <tr>
                                <td>Customer Name</td>
                                <td style="width: 10px; display: block">:</td>
                                <td id="cust_name"></td>
                            </tr>
                            <tr>
                                <td style="width: 110px">Account Type</td>
                                <td style="width: 10px; display: block">:</td>
                                <td id="account_type"></td>
                            </tr>

                        </table><br>
                        <table style="margin-left: 20px">
                            <tr>
                                <td><b>[ Image List ]</b></td>
                                <td></td>
                                <td id="list"></td>
                            </tr>
                            @if(isset($data))
                                @if(count($data))
                                    @foreach ($data as $key => $value)
                                    <tr>
                                        <td style="padding-right: 20px">
                                            <p>Text {{ $key+1 }}: {{ $value['text'] }}</p>
                                        </td>
                                        <td style="padding-left: 20px">
                                            <span style="margin: 0px; padding-right: 8px"><img class="imgThumb" style="border-style:solid;border-width:1px" width="150px" height="100px" data-id="{{ $value['id'] }}" src="data:image/png;base64,{{ $value['img'] }}"></span>
                                            <div id="zoomArea_{{ $value['id'] }}" style="position:fixed;display:none;z-index:5010;border:1px solid #000;background:#fff;pointer-events: none; "><img id="zoomImg_{{ $value['id'] }}" width="450px" height="300px" src=""></div>
                                            <br>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><br></td>
                                    </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td style="background-color: red"><i>Image doesnt exist.</i></td>
                                </tr>
                                @endif
                            @endif
                        </table>
                    </fieldset>
                </div>
            </div>
            <div class="card-footer clearfix">
                <button type="submit" id="btnEnter" class="btn btn-sm btn-primary"><i class="fa fa-check"></i> Submit</button>
                <a href="{{ url('view-signature') }}" type="button" class="btn btn-sm btn-danger"><i class="fa fa-redo"></i> Reset</a>
                <button type="button" id="btnToogle" class="btn btn-sm btn-secondary" onclick="toogle(this.id);"><i class="fa fa-recycle"></i> Toogle Account</button>
            </div>
        </form>
    </div>
    <!-- </div> -->
</div>
@endsection