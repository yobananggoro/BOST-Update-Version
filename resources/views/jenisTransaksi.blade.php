<label>Jenis Transaksi <span style="color: red">*</span></label>
<div class="input-group mb-1" style="padding-bottom: 10px">
    <select id="getTrxList" name="trxName" class="form-control" style="width: 100%"></select>
    <div id="jenisTrxOverlay" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.6);z-index:10;align-items:center;justify-content:center;">
        <i class="fa fa-spinner fa-spin fa-lg"></i>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <input type="text" name="dbCode" id="dbCode" class="form-control" placeholder="Trx Debet" readonly>
    </div>
    <div class="col-6">
        <input type="text" name="crCode" id="crCode" class="form-control" placeholder="Trx Credit" readonly>
    </div>
</div>