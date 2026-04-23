$(function () {
    if ($("#accuse").val() == "internal") {
        $("#extSrc").hide();
        $("#branchSrc,#cifSrc,#suffixSrc").show();
    } else {
        $("#accuse").show();
        $("#branchSrc,#cifSrc,#suffixSrc").hide();
    }

    $("#btnEnter").click(function () {
        // alert('das');
        var cek = validateForm();
        if (cek != "success") {
            alert(cek);
            return false;
        }
        const userConfirmed = confirm("Apakah anda yakin data sudah sesuai?");

        if (userConfirmed) {
            $(".loading-page").show();
            $("#formAccount").attr("target", "_self").submit();
        }
    });

    $("#nominal_").keyup(function () {
        var nom = $("#nominal_").val();
        nom.length > 0 ? $("#nominal").val(parseFloat(nom.replace(/,/g, ""))) : $("#nominal").val("");
    });

    $(".rekSumber").keyup(function (e) {
        $(".detailSrc").val("").html("");
    });

    $(".nar").keyup(function (e) {
        this.value = this.value.replace(/[\*\?:]/g, "");
    });

});

function validateForm() {
    var result = "success";
    var branchSrc = $("#branchSrc").val();
    var cifSrc = $("#cifSrc").val();
    var suffixSrc = $("#suffixSrc").val();
    var extSrc = $("#extSrc").val();
    let radioSelected = document.querySelector('input[name="isCheque"]:checked');
    // alert(radioSelected.value);

    if ($("#accuse").val() == "internal") {
        if (branchSrc == "" || cifSrc == "" || suffixSrc == "") {
            $("#branchSrc,#cifSrc,#suffixSrc").css("background-color", "red");

            result = "Rekening Sumber Tidak Boleh Kosong";
            return result;
        } else {
            $("#branchSrc,#cifSrc,#suffixSrc").css("background-color", "");
        }
    } else {
        if (extSrc == "") {
            $("#extSrc").css("background-color", "red");

            result = "Rekening Sumber Tidak Boleh Kosong";
            return result;
        } else {
            $("#extSrc").css("background-color", "");
        }
    }

    if ($("#tipeSrc").val() == "") {
        result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Sumber";
        return result;
    }

    // if (radioSelected.value == "Y") {
    //     if ($("#chequeNo").val() == "") {
    //         $("#chequeNo").css("background-color", "red");

    //         result = "Nomor Cheque Tidak Boleh Kosong";
    //         return result;
    //     } else {
    //         $("#chequeNo").css("background-color", "");
    //     }
    // }

    if ($("#nominal_").val() == "") {
        $("#nominal_").css("background-color", "red");

        result = "Nominal Tidak Boleh Kosong";
        return result;
    } else {
        $("#nominal_").css("background-color", "");
    }

    if ($("#nominal").val() == 0) {
        $("#nominal_").css("background-color", "red");

        result = "Nominal Tidak Boleh diisi Angka 0!";
        return result;
    } else {
        $("#nominal_").css("background-color", "");
    }

    if ($("#narative3").val() == "" && $("#narative4").val() != "") {
        result = "Silahkan isi kolom narative 3 terlebih dahulu!";
        return result;
    }

    if ($("#myfile").val() == "") {
        result = "File upload kosong!";
        return result;
    }

    /* Start validasi additional info apuppt */
    
    if ($("#getInstrumenList").val() == "" || $("#getInstrumenList").val() == null) {
        $("#getInstrumenList").siblings(".select2-container").find(".select2-selection").css("background-color", "red");

        result = "Instrumen Transaksi Tidak Boleh Kosong";
        return result;
    } else if ($("#getInstrumenList").val() == 99 && $("#instrumenLainnya").val() == "") {
        $("#instrumenLainnya").css("background-color", "red");
        $("#getInstrumenList").siblings(".select2-container").find(".select2-selection").removeAttr("style");

        result = "Instrumen Transaksi Lainnya Tidak Boleh Kosong";
        return result;
    } else {
        $("#getInstrumenList").siblings(".select2-container").find(".select2-selection").removeAttr("style");
        $("#instrumenLainnya").css("background-color", "");
    }

    if ($("#getKlasifikasiList").val() == "" || $("#getKlasifikasiList").val() == null) {
        $("#getKlasifikasiList").siblings(".select2-container").find(".select2-selection").css("background-color", "red");

        result = "Klasifikasi Transaksi Tidak Boleh Kosong";
        return result;
    } else if ($("#getKlasifikasiList").val() == 99 && $("#klasifikasiLainnya").val() == "") {
        $("#klasifikasiLainnya").css("background-color", "red");
        $("#getKlasifikasiList").siblings(".select2-container").find(".select2-selection").removeAttr("style");

        result = "Klasifikasi Transaksi Lainnya Tidak Boleh Kosong";
        return result;
    } else {
        $("#getKlasifikasiList").siblings(".select2-container").find(".select2-selection").removeAttr("style");
        $("#klasifikasiLainnya").css("background-color", "");
    }

    if ($("#getKepentinganList").val() == "" || $("#getKepentinganList").val() == null) {
        $("#getKepentinganList").siblings(".select2-container").find(".select2-selection").css("background-color", "red");

        result = "Kepentingan Transaksi Tidak Boleh Kosong";
        return result;
    } else if ($("#getKepentinganList").val() == 99 && $("#kepentinganLainnya").val() == "") {
        $("#kepentinganLainnya").css("background-color", "red");
        $("#getKepentinganList").siblings(".select2-container").find(".select2-selection").removeAttr("style");

        result = "Kepentingan Transaksi Lainnya Tidak Boleh Kosong";
        return result;
    } else {
        $("#getKepentinganList").siblings(".select2-container").find(".select2-selection").removeAttr("style");
        $("#kepentinganLainnya").css("background-color", "");
    }

    if ($("#getSumberDanaList").val() == "" || $("#getSumberDanaList").val() == null) {
        $("#getSumberDanaList").siblings(".select2-container").find(".select2-selection").css("background-color", "red");

        result = "Sumber Dana Tidak Boleh Kosong";
        return result;
    } else if ($("#getSumberDanaList").val() == 9 && $("#sumberDanaLainnya").val() == "") {
        $("#sumberDanaLainnya").css("background-color", "red");
        $("#getSumberDanaList").siblings(".select2-container").find(".select2-selection").removeAttr("style");

        result = "Sumber Dana Lainnya Tidak Boleh Kosong";
        return result;
    } else {
        $("#getSumberDanaList").siblings(".select2-container").find(".select2-selection").removeAttr("style");
        $("#sumberDanaLainnya").css("background-color", "");
    }

    if ($("#getTujuanList").val() == "" || $("#getTujuanList").val() == null) {
        $("#getTujuanList").siblings(".select2-container").find(".select2-selection").css("background-color", "red");

        result = "Tujuan Transaksi Tidak Boleh Kosong";
        return result;
    } else if ($("#getTujuanList").val() == 9 && $("#tujuanLainnya").val() == "") {
        $("#tujuanLainnya").css("background-color", "red");
        $("#getTujuanList").siblings(".select2-container").find(".select2-selection").removeAttr("style");

        result = "Tujuan Transaksi Lainnya Tidak Boleh Kosong";
        return result;
    } else {
        $("#getTujuanList").siblings(".select2-container").find(".select2-selection").removeAttr("style");
        $("#tujuanLainnya").css("background-color", "");
    }

    /* Start validasi additional info apuppt */

    return "success";
}

function detailSumber() {
    // alert('ds');
    var branch = $("#branchSrc").val();
    var cif = $("#cifSrc").val();
    var suffix = $("#suffixSrc").val();
    var ext = $("#extSrc").val();
    var accuse = $("#accuse").val();

    $("#nama_sumber").html("");
    $("#tipe_rek_sumber").html("");
    $("#tipe_ccy_sumber").html("");
    $("#tipeSrc").val("");
    $("#namaSrc").val("");
    $("#ccySrc").val("");

    if (accuse == "internal") {
        if (branch.length < 4 || cif.length < 6 || suffix.length < 3) {
            $("#branchSrc,#cifSrc,#suffixSrc").css("background-color", "red");

            alert("Pastikan Branch CIF Suffix di Rekening Sumber sesuai ketentuan.");
            return false;
        } else {
            $("#branchSrc,#cifSrc,#suffixSrc").css("background-color", "");
        }
    } else {
        if (ext.length < 13) {
            $("#extSrc").css("background-color", "red");

            alert("Pastikan Rekening Eksternal di Rekening Sumber sesuai ketentuan.");
            return false;
        } else {
            $("#extSrc").css("background-color", "");
        }
    }

    $(".loading-page").show(); //show progress bar

    $.ajax({
        url: "account-gi",
        type: "POST",
        data:
            accuse == "internal"
                ? {
                      branch: branch,
                      cif: cif,
                      suffix: suffix,
                  }
                : {
                      extAcctNumber: ext,
                  },
        success: function (data) {
            $(".loading-page").hide(); //show progress bar
            // console.log(data);
            if (data.status == 200) {
                if (data.code == "00") {
                    $("#nama_sumber").html(data.accountShortName);
                    $("#tipe_rek_sumber").html(data.accountType);
                    $("#tipe_ccy_sumber").html(data.currency);

                    $("#branchSrc").val(data.branch);
                    $("#cifSrc").val(data.cif);
                    $("#suffixSrc").val(data.suffix);
                    $("#extSrc").val(data.externalAccountNumber);
                    $("#tipeSrc").val(data.accountType);
                    $("#namaSrc").val(data.accountShortName);
                    $("#ccySrc").val(data.currency);

                    $(".toastrDefaultInfo").show(function () {
                        if (accuse == "internal") {
                            toastr.info(data.branch + "-" + data.cif + "-" + data.suffix + " | Data ditemukan!");
                        } else {
                            toastr.info(data.externalAccountNumber + " | Data ditemukan!");
                        }
                    });
                } else {
                    $(".toastrDefaultError").show(function () {
                        if (accuse == "internal") {
                            toastr.error(branch + "-" + cif + "-" + suffix + " <br> " + data.msgdesc);
                        } else {
                            toastr.error(ext + " <br> " + data.msgdesc);
                        }
                    });
                }
            } else {
                $(".toastrDefaultError").show(function () {
                    toastr.error(data.message);
                });
            }
        },
        error: function (error) {
            $(".loading-page").hide();
            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });
        },
    });
}

function toogle(id) {
    if ($("#accuse").val() == "external") {
        $("#extSrc").hide();
        $("#branchSrc,#cifSrc,#suffixSrc").show();
        $("#accuse").val("internal");
    } else {
        $("#extSrc").show();
        $("#branchSrc,#cifSrc,#suffixSrc").hide();
        $("#accuse").val("external");
    }

    $("#branchSrc,#cifSrc,#suffixSrc,#extSrc").css("background-color", "");
}

var i = 1;
function valCheque(e) {
    if (e == "Y") {
        if (i <= 1) {
            $("#numbCheck").append('<div id="fieldCheque" class="col-12"><label>Nomor Cheque <span style="color: red">*</span></label><input type="text" name="chequeNo" id="chequeNo" maxlength="16" class="form-control number" placeholder="Nomor Cheque"><br></div>');
            ++i;
            return i;
        }
    } else {
        $("#fieldCheque").remove();
        i--;
        return i;
    }
}


