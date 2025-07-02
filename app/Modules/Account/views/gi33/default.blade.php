
@extends('layouts.app')
@section('title', 'Account [PROMPT]')
@section('content')
<div class="col-sm-5">
    <div class="card card-default">
        <div class="card-body">
            <form action="{{ route('account-gi.store') }}" method="post" role="form" class="form-horizontal">
                @csrf
                <input type="hidden" name="accuse" id="accuse" value="{{@$accuse}}" />
                <div class="form-group" id="extr">
                    <label>Account</label>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" id="extAcctNumber" class="form-control numeric" name="extAcctNumber" value="{{@$acctNumber}}" maxlength="13" placeholder="External Account">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" id="branch" class="form-control numeric" name="branch" value="{{@$branch}}" maxlength="4" placeholder="Branch">
                        </div>
                        <div class="col-sm-6">
                            <input type="text" id="cif" class="form-control ucase" name="cif" value="{{@$cif}}" maxlength="6" placeholder="Cif">
                        </div>
                        <div class="col-sm-3">
                            <input type="text" id="suffix" class="form-control numeric" name="suffix" value="{{@$suffix}}" maxlength="3" placeholder="Suffix">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer"> 
                <!-- <button type="submit" id="btnEnter" class="btn btn-primary">Submit</button> -->
                <button type="submit" class="btn btn-warning">Get Detail</button>
            </form>
            <button id="btnToggleAccount" class="btn btn-default float-right">Toogle</button>
            <a type="button" href="{{url('account-gi')}}" class="btn btn-danger">Reset</a>
        </div>  
    </div>
</div>
<div class="col-sm-5">
    <div class="card card-default" @if(@$accountShortName) style="display:" @else style="display: none" @endif>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12">
                    <table cellspacing="0" cellpadding="0">
                        <tbody>
                            <tr>
                                <td style="width: 130px">Account</td>
                                <td style="width: 25px"> :</td>
                                <td style="width: 200px">{{@$accountNumber}}</td>
                                <td style="width: 250px; text-align: right"><b>{{@$accountShortName}}</b></td>
                            </tr>
                            <tr>
                                <td>Account Number</td>
                                <td> :</td>
                                <td>{{@$externalAccountNumber}}</td>
                            </tr>
                            <tr>
                                <td>Account Type</td>
                                <td> :</td>
                                <td>{{@$accountType}}</td>
                            </tr>
                            <tr>
                                <td>Currency</td>
                                <td> :</td>
                                <td>{{@$currency}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection