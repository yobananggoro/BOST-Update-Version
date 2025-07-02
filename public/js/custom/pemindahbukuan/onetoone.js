$(function () {
    if ($("#accuseSrc").val() == "internal") {
        $("#extSrc").hide();
        $("#branchSrc,#cifSrc,#suffixSrc").show();
    } else {
        $("#extSrc").show();
        $("#branchSrc,#cifSrc,#suffixSrc").hide();
    }

    if ($("#accuseDst").val() == "internal") {
        $("#extDst").hide();
        $("#branchDst,#cifDst,#suffixDst").show();
    } else {
        $("#extDst").show();
        $("#branchDst,#cifDst,#suffixDst").hide();
    }

    $("#btnEnter").click(function () {
        // alert('das');
        var cek = validateForm();
        if (cek != "success") {
            alert(cek);
            return false;
        }
        $(".loading-page").show();
        $("#formAccount").attr("target", "_self").submit();
    });

    $("#listRekening").click(function () {
        //resetContent()
    });

    $("#nominal_").keyup(function () {
        var nom = $("#nominal_").val();

        if (nom.length > 0) {
            $("#nominal").val(parseFloat(nom.replace(/,/g, "")));
        } else {
            $("#nominal").val("");
        }
    });

    $(".rekSumber").keyup(function (e) {
        $(".detailSrc").val("");
        $(".detailSrc").html("");
    });

    $(".rekTujuan").keyup(function (e) {
        $(".detailDst").val("");
        $(".detailDst").html("");
    });

    $(".nar").keyup(function (e) {
        this.value = this.value.replace(/[^a-zA-Z0-9 \t\n\r]/g, "");
    });
});

function validateForm() {
    var result = "success";
    var branchSrc = $("#branchSrc").val();
    var cifSrc = $("#cifSrc").val();
    var suffixSrc = $("#suffixSrc").val();
    var extSrc = $("#extSrc").val();
    var accuseSrc = $("#accuseSrc").val();
    var branchDst = $("#branchDst").val();
    var cifDst = $("#cifDst").val();
    var suffixDst = $("#suffixDst").val();
    var extDst = $("#extDst").val();

    //Kolom Rekening Sumber Start
    if (accuseSrc == "internal") {
        if (branchSrc.length < 4 || cifSrc.length < 6 || suffixSrc.length < 3) {
            $("#branchSrc,#cifSrc,#suffixSrc").css("background-color", "red");

            result = "Rekening Internal pada Rekening Sumber tidak sesuai ketentuan.";
            return result;
        } else {
            $("#branchSrc,#cifSrc,#suffixSrc").css("background-color", "");
        }
    } else {
        if (extSrc.length < 13) {
            $("#extSrc").css("background-color", "red");

            result = "Rekening Eksternal pada Rekening Sumber tidak sesuai ketentuan.";
            return result;
        } else {
            $("#extSrc").css("background-color", "");
        }
    }

    if ($("#tipeSrc").val() == "") {
        result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Sumber";
        return result;
    }
    //Kolom Rekening Sumber Start End

    
    //Kolom Rekening Tujuan Start
    if ($("#accuseDst").val() == "internal") {
        if (branchDst.length < 4 || cifDst.length < 6 || suffixDst.length < 3) {
            $("#branchDst,#cifDst,#suffixDst").css("background-color", "red");

            result = "Rekening Internal pada Rekening Tujuan tidak sesuai ketentuan.";
            return result;
        } else {
            $("#branchDst,#cifDst,#suffixDst").css("background-color", "");
        }
    } else {
        if (extDst.length < 13) {
            $("#extDst").css("background-color", "red");

            result = "Rekening Eksternal pada Rekening Tujuan tidak sesuai ketentuan.";
            return result;
        } else {
            $("#branchDst,#cifDst,#suffixDst").css("background-color", "");
        }
    }

    if ($("#tipeDst").val() == "") {
        result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Tujuan";
        return result;
    }
    //Kolom Rekening Tujuan End

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

    return "success";
}

function validasiLimit() {
    var nominal = parseInt(document.getElementById("nominal").value);
    var limit = parseInt(document.getElementById("limit").value);

    if (nominal > limit) {
        alert("Limit melebihi ketentuan, silahkan lakukan otorisasi!");
        $("#otorisasi,#subm").show();
        $("#verified").hide();
    } else {
        $("#verified").hide();
        $("#subm").show();
    }
}

function detailSumber() {
    var branch = $("#branchSrc").val();
    var cif = $("#cifSrc").val();
    var suffix = $("#suffixSrc").val();
    var ext = $("#extSrc").val();
    var accuse = $("#accuseSrc").val();

    $("#nama_sumber").html("");
    $("#tipe_rek_sumber").html("");
    $("#tipe_ccy_sumber").html("");
    $("#tipeSrc").val("");
    $("#namaSrc").val("");
    $("#ccySrc").val("");

    if ($("#accuseSrc").val() == "internal") {
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
                        toastr.info("Data ditemukan!");
                    });
                } else {
                    $(".toastrDefaultError").show(function () {
                        toastr.error(data.msgdesc);
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

function detailTujuan() {
    var branch = $("#branchDst").val();
    var cif = $("#cifDst").val();
    var suffix = $("#suffixDst").val();
    var ext = $("#extDst").val();
    var accuse = $("#accuseDst").val();

    $("#nama_tujuan").html("");
    $("#tipe_rek_tujuan").html("");
    $("#tipe_ccy_tujuan").html("");
    $("#tipeDst").val("");
    $("#namaDst").val("");
    $("#ccyDst").val("");

    if ($("#accuseDst").val() == "internal") {
        if (branch.length < 4 || cif.length < 6 || suffix.length < 3) {
            $("#branchDst,#cifDst,#suffixDst").css("background-color", "red");

            alert("Pastikan Branch CIF Suffix di Rekening Tujuan sesuai ketentuan.");
            return false;
        } else {
            $("#branchDst,#cifDst,#suffixDst").css("background-color", "");
        }
    } else {
        if (ext.length < 13) {
            $("#extDst").css("background-color", "red");

            alert("Pastikan Rekening Eksternal di Rekening Tujuan sesuai ketentuan.");
            return false;
        } else {
            $("#extDst").css("background-color", "");
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
                    $("#nama_tujuan").html(data.accountShortName);
                    $("#tipe_rek_tujuan").html(data.accountType);
                    $("#tipe_ccy_tujuan").html(data.currency);

                    $("#branchDst").val(data.branch);
                    $("#cifDst").val(data.cif);
                    $("#suffixDst").val(data.suffix);
                    $("#extDst").val(data.externalAccountNumber);
                    $("#tipeDst").val(data.accountType);
                    $("#namaDst").val(data.accountShortName);
                    $("#ccyDst").val(data.currency);

                    $(".toastrDefaultInfo").show(function () {
                        toastr.info("Data ditemukan!");
                    });
                } else {
                    $(".toastrDefaultError").show(function () {
                        toastr.error(data.msgdesc);
                    });
                }
            } else {
                $(".toastrDefaultError").show(function () {
                    toastr.error(data.message);
                });
            }
        },
        error: function (error) {
            $(".loading-page").hide(); //hide progress bar
            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });
        },
    });
}

function toogle(id) {
    if (id == "btnToogleSrc") {
        if ($("#accuseSrc").val() == "external") {
            $("#extSrc").hide();
            $("#branchSrc,#cifSrc,#suffixSrc").show();
            $("#accuseSrc").val("internal");
        } else {
            $("#extSrc").show();
            $("#branchSrc,#cifSrc,#suffixSrc").hide();
            $("#accuseSrc").val("external");
        }

        $("#branchSrc,#cifSrc,#suffixSrc,#extSrc").css("background-color", "");
    } else {
        if ($("#accuseDst").val() == "external") {
            $("#extDst").hide();
            $("#branchDst,#cifDst,#suffixDst").show();
            $("#accuseDst").val("internal");
        } else {
            $("#extDst").show();
            $("#branchDst,#cifDst,#suffixDst").hide();
            $("#accuseDst").val("external");
        }

        $("#branchDst,#cifDst,#suffixDst,#extDst").css("background-color", "");
    }
}
