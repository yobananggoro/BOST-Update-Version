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
                                    <label class="col-sm-2 col-form-label">Nama Account</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="namaRekening">
                                    </div>
                                </div>
                                <div class="form-group form-horizontal row">
                                    <label class="col-sm-2 col-form-label">Nomor CIF</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" id="cifRekening">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-sm btn-info" onclick="listRekening()"><i class="fa fa-search"></i> Filter</button>
                            </div>
                        </div>
                    </div>
                    <style>
                        .table-container {
                            height: 300px;
                            overflow-y: auto;
                        }

                        .table thead th {
                            position: sticky;
                            top: 0;
                            background: #93929a;
                            /* wajib */
                            z-index: 2;
                        }
                    </style>
                    <div class="table-container">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:50px">No.</th>
                                    <th class="text-center" style="width:400px">Nama Rekening</th>
                                    <th class="text-center" style="width:150px">Nomor Internal</th>
                                    <th class="text-center" style="width:150px">Nomor External</th>
                                    <th class="text-center" style="width:80px">Tipe</th>
                                    <th class="text-center" style="width:80px">Ccy</th>
                                </tr>
                            </thead>
                            <tbody id="tableData">
                            </tbody>
                        </table>
                    </div>
                    <p id="halaman" class="text-right"></p>
                    <input type="hidden" id="paging">
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-sm btn-primary" id="prev" style="visibility: hidden" onclick="paginate(this.id)"><i class="fa fa-arrow-left"></i> Prev</button>
                <button type="button" class="btn btn-sm btn-primary" id="next" style="visibility: hidden" onclick="paginate(this.id)"><i class="fa fa-arrow-right"></i> Next</button>
            </div>
        </div>
    </div>
</div>