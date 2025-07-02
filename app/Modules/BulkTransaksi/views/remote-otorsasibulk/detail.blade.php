@extends('layouts.app')
@section('title', 'Detail Upload File')
@section('content')
<div class="row">
	<div class="col-12">
		<div class="card card-default">
			<div class="card-header border-0">
				<div class="float-right" id="searchContainer"></div>
				<table class="float-left" cellspacing="0" cellpadding="0" style="font-weight: bold; font-size: 15px">
					<tbody>
						<tr>
							<td style="width: 140px; text-align: left">Page</td>
							<td style="width: 15px; text-align: left">:</td>
							<td style="width: 80px; text-align: left">{{$page}}</td>
						</tr>
						<tr>
							<td style="text-align: left">Total rows</td>
							<td style="text-align: left">:</td>
							<td style="text-align: left">{{number_format($request->rows, 0, '', '.')}} rows</td>
						</tr>
						<tr>
							<td style="text-align: left">Total rows per page</td>
							<td style="text-align: left">:</td>
							<!-- <td style="text-align: left">{{number_format(count($data), 0, '', '.')}} rows</td> -->
							<td style="text-align: left">{{number_format($size, 0, '', '.')}} rows</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="card-body table-responsive" style="max-height: 650px; overflow-y: scroll">
				<!-- <table class="table table-striped table-head-fixed" style="width: 150%"> -->
				<table id="dataTableDetailUpload" class="table table-striped" style="width: 170%">
					<thead>
						<tr>
							<th style="width:10px">No.</th>
							<th style="width:100px">Trx Code</th>
							<th>Cheque No</th>
							<th>Account</th>
							<th>Account Name</th>
							<th>Account Status</th>
							<th>Ccy</th>
							<th>Amount</th>
							<th>Nar 1</th>
							<th>Nar 2</th>
							<th>Nar 3</th>
							<th>Nar 4</th>
							<th>Trx Status</th>
							<th>Posting Date</th>
							<th>Created Date</th>
							<th>Updated Date</th>
						</tr>
					</thead>
					<tbody>
						@foreach($data as $key => $d)
						<tr>
							@if($d['trxType'] != 'dc')
							<td>{{ $key+1 }}.</td>
							<td>{{ $d['trxType'] == 'd' ? $d['trxCodeDebit'].' (D) ' : $d['trxCodeCredit'].' (C) '}}</td>
							<td>{{ $d['chequeNumber'] }}</td>
							<td>{{ $d['trxType'] == 'd' ? $d['srcAccountNumber'] : $d['dstAccountNumber'] }}</td>
							<td>{{ $d['accountName'] }}</td>
							<td>{{ $d['accountStatus'] }}</td>
							<td>{{ $d['trxType'] == 'd' ? $d['srcCcy'] : $d['dstCcy'] }}</td>
							<td class="text-right">{{ number_format($d['trxAmount'],2) }}</td>
							<td>{{ $d['trxType'] == 'd' ? $d['nar1'] : $d['nar5'] }}</td>
							<td>{{ $d['trxType'] == 'd' ? $d['nar2'] : $d['nar6'] }}</td>
							<td>{{ $d['trxType'] == 'd' ? $d['nar3'] : $d['nar7'] }}</td>
							<td>{{ $d['trxType'] == 'd' ? $d['nar4'] : $d['nar8'] }}</td>
							<td>{{ $d['trxStatus'] }}</td>
							<td>{{ $d['postingDt'] }}</td>
							<td>{{ $d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : '' }}</td>
							<td>{{ $d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : '' }}</td>
							@else
							<td>{{ $key+1 }}.</td>
							<td>{{ $d['trxCodeDebit'].' (D) '}}<br>{{$d['trxCodeCredit'].' (C) '}}</td>
							<td>{{ $d['srcAccountNumber'] }}<br>{{ $d['dstAccountNumber'] }}</td>
							<td>{{ $d['accountName'] }}</td>
							<td>{{ $d['accountStatus'] }}</td>
							<td>{{ $d['trxType'] == 'd' ? $d['srcCcy'] : $d['dstCcy'] }}</td>
							<td class="text-right">{{ number_format($d['trxAmount'],2) }}</td>
							<td>{!! $d['trxType'] == 'd' ? $d['nar1'] : $d['nar1']."<br>".$d['nar5'] !!}</td>
							<td>{!! $d['trxType'] == 'd' ? $d['nar2'] : $d['nar2']."<br>".$d['nar6'] !!}</td>
							<td>{!! $d['trxType'] == 'd' ? $d['nar3'] : $d['nar3']."<br>".$d['nar7'] !!}</td>
							<td>{!! $d['trxType'] == 'd' ? $d['nar4'] : $d['nar4']."<br>".$d['nar8'] !!}</td>
							<td>{{ $d['trxStatus'] }}</td>
							<td>{{ $d['postingDt'] }}</td>
							<td>{{ $d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : '' }}</td>
							<td>{{ $d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : '' }}</td>
							@endif
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="card-footer clearfix">
				<div class="row">
					<div class="col-6">
						<span class="metadata" id="isFinger" title="{{ auth()->user()->profile->isFinger == true ? '1':'0' }}"></span>
						<form action="{{ url('remote-otorisasibulk/approval') }}" method="post" role="form" class="form-horizontal">
							@csrf
							<input type="hidden" name="idFile" value="{{ request()->query('id') }}" readonly>
							<input type="hidden" name="amount" value="{{ request()->query('amount') }}" readonly>
							<input type="hidden" name="reff" value="{{ request()->query('reff') }}" readonly>
							@if(hasModulePermission('remote-otorisasi'))
							@if(auth()->user()->profile->isFinger == true)
							<div class="row">
								@include('fingerstatus::otoFinger')
							</div><br>
							@endif

							<div class="btn-group">
								<button type="button" id="btnApprove" class="btn btn-sm btn-success col-sm-12" style="width: 90px">
									<i class="fa fa-check"></i> Approve
								</button>
								<button type="submit" id="approveBTN" class="btn btn-sm btn-default col-sm-12" name="subject" value="approve" style="display: none"></button>
							</div>
							<div class="btn-group">
								<button type="button" id="btnReject" class="btn btn-sm btn-danger col-sm-12" style="width: 90px">
									<i class="fa fa-times"></i>
									Reject
								</button>
								<button type="submit" id="rejectBTN" class="btn btn-sm btn-default col-sm-12" name="subject" value="reject" style="display: none"></button>
							</div>
							@endif
						</form>
						<!-- <h8><b>Total rows: {{number_format($request->rows, 0, '', '.')}}</b></h8> -->
					</div>
					<div class="col-6">
						<div class="btn-group float-right">
							<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="align-content: flex-end">
								<ul class="pagination">
									@if($page <= 0 )
										<li class="paginate_button page-item previous disabled" id="example1_previous">
										<a type="button" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
											‹
										</a>
										</li>
										@else
										<li class="paginate_button page-item previous" id="example1_previous">
											<a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page-1, 'rows' => $request->rows]) }}" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
												‹
											</a>
										</li>
										@endif

										<li class="paginate_button page-item next" id="example1_next">
											<a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => 0, 'rows' => $request->rows]) }}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
												First
											</a>
										</li>
										@for ($i = 0; $i <= ceil($request->rows/$size)-1; $i++)
											@php
											$startpage=$page - 2;
											$endpage=$page + 2;
											@endphp
											@if ($i >= $startpage && $i <= $endpage)
												@if ($i==$page)
												<li class="paginate_button page-item active">
												<a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page, 'rows' => $request->rows]) }}" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
													{{$i}}
												</a>
												</li>
												@else
												<li class="paginate_button page-item">
													<a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $i, 'rows' => $request->rows]) }}" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
														{{$i}}
													</a>
												</li>
												@endif
												@endif
												@endfor
												<li class="paginate_button page-item next" id="example1_next">
													<a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => ceil($request->rows/$size)-1, 'rows' => $request->rows]) }}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
														Last
													</a>
												</li>
												@if ((@$page) >= ceil($request->rows/$size)-1)
												<li class="paginate_button page-item disabled" id="example1_next">
													<a type="button" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
														›
													</a>
												</li>
												@else
												<li class="paginate_button page-item next" id="example1_next">
													<a href="{{ route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page+1, 'rows' => $request->rows]) }}" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
														›
													</a>
												</li>
												@endif
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection