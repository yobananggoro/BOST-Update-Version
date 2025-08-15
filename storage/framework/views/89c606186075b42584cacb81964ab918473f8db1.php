<div class="modal fade" id="modal-xl">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">List Rekening</h4>
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="col-12">
                    <div class="card card-default">
                        <div class="card-body">
                            <div class="card-body">
                                <div class="form-group form-horizontal row">
                                    <label class="col-sm-2 col-form-label">Nomor CIF</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" id="cifRekening">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer"> 
                                <button type="submit" class="btn btn-info" onclick="listRekening()">Cari</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead style="background-color: rgba(172, 169, 183, 0.757)">
                            <tr>
                                <th class="text-center" style="width:50px">No.</th>
                                <th class="text-center">Nama Rekening</th>
                                <th class="text-center" style="width:230px">No Rek Internal</th>
                                <th class="text-center" style="width:230px">No Rek Eksternal</th>
                                <th class="text-center" style="width:150px">Tipe Rekening</th>
                                <th class="text-center" style="width:100px">Currency</th>
                            </tr>
                        </thead>
                        <tbody id="tableData">
                        </tbody>
                    </table>
                    <p id="halaman" class="text-right"></p>
                    <input type="hidden" id="paging">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-primary" id="prev" style="visibility: hidden" onclick="paginate(this.id)">Prev</button>
                <button type="button" class="btn btn-primary" id="next" onclick="paginate(this.id)">Next</button>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\Data\Kerjaan\Bjb\Aplikasi AMT\Back Office\App\Local\bulk_kosongan\app\Modules\Account\Providers/../views/ab/modal.blade.php ENDPATH**/ ?>