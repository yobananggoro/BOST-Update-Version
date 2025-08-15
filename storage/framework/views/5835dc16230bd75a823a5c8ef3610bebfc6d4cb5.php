
<?php $__env->startSection('title', 'Detail Upload File'); ?>
<?php $__env->startSection('content'); ?>
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
							<td style="width: 80px; text-align: left"><?php echo e($page); ?></td>
						</tr>
						<tr>
							<td style="text-align: left">Total rows</td>
							<td style="text-align: left">:</td>
							<td style="text-align: left"><?php echo e(number_format($request->rows, 0, '', '.')); ?> rows</td>
						</tr>
						<tr>
							<td style="text-align: left">Total rows per page</td>
							<td style="text-align: left">:</td>
							<!-- <td style="text-align: left"><?php echo e(number_format(count($data), 0, '', '.')); ?> rows</td> -->
							<td style="text-align: left"><?php echo e(number_format($size, 0, '', '.')); ?> rows</td>
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
						<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						<tr>
							<?php if($d['trxType'] != 'dc'): ?>
							<td><?php echo e($key+1); ?>.</td>
							<td><?php echo e($d['trxType'] == 'd' ? $d['trxCodeDebit'].' (D) ' : $d['trxCodeCredit'].' (C) '); ?></td>
							<td><?php echo e($d['chequeNumber']); ?></td>
							<td><?php echo e($d['trxType'] == 'd' ? $d['srcAccountNumber'] : $d['dstAccountNumber']); ?></td>
							<td><?php echo e($d['accountName']); ?></td>
							<td><?php echo e($d['accountStatus']); ?></td>
							<td><?php echo e($d['trxType'] == 'd' ? $d['srcCcy'] : $d['dstCcy']); ?></td>
							<td class="text-right"><?php echo e(number_format($d['trxAmount'],2)); ?></td>
							<td><?php echo e($d['trxType'] == 'd' ? $d['nar1'] : $d['nar5']); ?></td>
							<td><?php echo e($d['trxType'] == 'd' ? $d['nar2'] : $d['nar6']); ?></td>
							<td><?php echo e($d['trxType'] == 'd' ? $d['nar3'] : $d['nar7']); ?></td>
							<td><?php echo e($d['trxType'] == 'd' ? $d['nar4'] : $d['nar8']); ?></td>
							<td><?php echo e($d['trxStatus']); ?></td>
							<td><?php echo e($d['postingDt']); ?></td>
							<td><?php echo e($d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : ''); ?></td>
							<td><?php echo e($d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : ''); ?></td>
							<?php else: ?>
							<td><?php echo e($key+1); ?>.</td>
							<td><?php echo e($d['trxCodeDebit'].' (D) '); ?><br><?php echo e($d['trxCodeCredit'].' (C) '); ?></td>
							<td><?php echo e($d['srcAccountNumber']); ?><br><?php echo e($d['dstAccountNumber']); ?></td>
							<td><?php echo e($d['accountName']); ?></td>
							<td><?php echo e($d['accountStatus']); ?></td>
							<td><?php echo e($d['trxType'] == 'd' ? $d['srcCcy'] : $d['dstCcy']); ?></td>
							<td class="text-right"><?php echo e(number_format($d['trxAmount'],2)); ?></td>
							<td><?php echo $d['trxType'] == 'd' ? $d['nar1'] : $d['nar1']."<br>".$d['nar5']; ?></td>
							<td><?php echo $d['trxType'] == 'd' ? $d['nar2'] : $d['nar2']."<br>".$d['nar6']; ?></td>
							<td><?php echo $d['trxType'] == 'd' ? $d['nar3'] : $d['nar3']."<br>".$d['nar7']; ?></td>
							<td><?php echo $d['trxType'] == 'd' ? $d['nar4'] : $d['nar4']."<br>".$d['nar8']; ?></td>
							<td><?php echo e($d['trxStatus']); ?></td>
							<td><?php echo e($d['postingDt']); ?></td>
							<td><?php echo e($d['createdAt'] != null ? date('d M Y H:i:s', strtotime($d['createdAt'])) : ''); ?></td>
							<td><?php echo e($d['updatedAt'] != null ? date('d M Y H:i:s', strtotime($d['updatedAt'])) : ''); ?></td>
							<?php endif; ?>
						</tr>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>
			</div>
			<div class="card-footer clearfix">
				<div class="row">
					<div class="col-6">
						<span class="metadata" id="isFinger" title="<?php echo e(auth()->user()->profile->isFinger == true ? '1':'0'); ?>"></span>
						<form action="<?php echo e(url('remote-otorisasibulk/approval')); ?>" method="post" role="form" class="form-horizontal">
							<?php echo csrf_field(); ?>
							<input type="hidden" name="idFile" value="<?php echo e(request()->query('id')); ?>" readonly>
							<input type="hidden" name="amount" value="<?php echo e(request()->query('amount')); ?>" readonly>
							<input type="hidden" name="reff" value="<?php echo e(request()->query('reff')); ?>" readonly>
							<?php if(hasModulePermission('remote-otorisasi')): ?>
							<?php if(auth()->user()->profile->isFinger == true): ?>
							<div class="row">
								<?php echo $__env->make('fingerstatus::otoFinger', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
							</div><br>
							<?php endif; ?>

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
							<?php endif; ?>
						</form>
						<!-- <h8><b>Total rows: <?php echo e(number_format($request->rows, 0, '', '.')); ?></b></h8> -->
					</div>
					<div class="col-6">
						<div class="btn-group float-right">
							<div class="dataTables_paginate paging_simple_numbers" id="example1_paginate" style="align-content: flex-end">
								<ul class="pagination">
									<?php if($page <= 0 ): ?>
										<li class="paginate_button page-item previous disabled" id="example1_previous">
										<a type="button" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
											‹
										</a>
										</li>
										<?php else: ?>
										<li class="paginate_button page-item previous" id="example1_previous">
											<a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page-1, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="0" tabindex="0" class="page-link">
												‹
											</a>
										</li>
										<?php endif; ?>

										<li class="paginate_button page-item next" id="example1_next">
											<a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => 0, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
												First
											</a>
										</li>
										<?php for($i = 0; $i <= ceil($request->rows/$size)-1; $i++): ?>
											<?php
											$startpage=$page - 2;
											$endpage=$page + 2;
											?>
											<?php if($i >= $startpage && $i <= $endpage): ?>
												<?php if($i==$page): ?>
												<li class="paginate_button page-item active">
												<a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
													<?php echo e($i); ?>

												</a>
												</li>
												<?php else: ?>
												<li class="paginate_button page-item">
													<a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $i, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="1" tabindex="0" class="page-link">
														<?php echo e($i); ?>

													</a>
												</li>
												<?php endif; ?>
												<?php endif; ?>
												<?php endfor; ?>
												<li class="paginate_button page-item next" id="example1_next">
													<a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => ceil($request->rows/$size)-1, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
														Last
													</a>
												</li>
												<?php if((@$page) >= ceil($request->rows/$size)-1): ?>
												<li class="paginate_button page-item disabled" id="example1_next">
													<a type="button" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
														›
													</a>
												</li>
												<?php else: ?>
												<li class="paginate_button page-item next" id="example1_next">
													<a href="<?php echo e(route('list-bulkupload.listDetail', ['id' => $request->id, 'page' => $page+1, 'rows' => $request->rows])); ?>" aria-controls="example1" data-dt-idx="2" tabindex="0" class="page-link">
														›
													</a>
												</li>
												<?php endif; ?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\app\Modules\BulkTransaksi\Providers/../views/remote-otorsasibulk/detail.blade.php ENDPATH**/ ?>