<fieldset style="border: solid 1px #a5a5a5; padding: 10px;">
    <legend>
        <h5>Additional Info</h5>
    </legend>
    <div class="col-12 form-group">
        <label>Instrumen Transaksi <span style="color: red">*</span></label>
        <div class="input-group mb-1">
            <select id="getInstrumenList" name="instrumentrx" class="form-control" style="width: 100%" ;>
            </select>
            <div id="instrumenOverlay" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.6);z-index:10;align-items:center;justify-content:center;">
                <i class="fa fa-spinner fa-spin fa-lg"></i>
            </div>
        </div>
        <div id="getInstrumentText"></div>
    </div>
    <div class="col-12 form-group">
        <label>Klasifikasi Transaksi <span style="color: red">*</span></label>
        <div class="input-group mb-1">
            <select id="getKlasifikasiList" name="klasifikasitrx" class="form-control" style="width: 100%">
            </select>
            <div id="klasifikasiOverlay" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.6);z-index:10;align-items:center;justify-content:center;">
                <i class="fa fa-spinner fa-spin fa-lg"></i>
            </div>
        </div>
        <div id="getKlasifikasiText"></div>
    </div>
    <div class="col-12 form-group">
        <label>Kepentingan Transaksi <span style="color: red">*</span></label>
        <div class="input-group mb-1">
            <select id="getKepentinganList" name="kepentingantrx" class="form-control" style="width: 100%">
            </select>
            <div id="kepentinganOverlay" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.6);z-index:10;align-items:center;justify-content:center;">
                <i class="fa fa-spinner fa-spin fa-lg"></i>
            </div>
        </div>
        <div id="getKepentinganText"></div>
    </div>
    <div class="col-12 form-group">
        <label>Sumber Dana <span style="color: red">*</span></label>
        <div class="input-group mb-1">
            <select id="getSumberDanaList" name="sumberdanatrx" class="form-control" style="width: 100%">
            </select>
            <div id="sumberDanaOverlay" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.6);z-index:10;align-items:center;justify-content:center;">
                <i class="fa fa-spinner fa-spin fa-lg"></i>
            </div>
        </div>
        <div id="getSumberDanaText"></div>
    </div>
    <div class="col-12 form-group">
        <label>Tujuan Transaksi <span style="color: red">*</span></label>
        <div class="input-group mb-1">
            <select id="getTujuanList" name="tujuantrx" class="form-control" style="width: 100%">
            </select>
            <div id="tujuanOverlay" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,0.6);z-index:10;align-items:center;justify-content:center;">
                <i class="fa fa-spinner fa-spin fa-lg"></i>
            </div>
        </div>
        <div id="getTujuanText"></div>
    </div>
    <div class="col-12 form-group">
        <label>Berita Transaksi <span style="color: red">*</span></label>
        <div class="input-group mb-1">
            <input type="text" name="beritaTrx" id="beritaTrx" class="form-control" maxlength="35" placeholder="Berita Transaksi">
        </div>
    </div>
</fieldset>