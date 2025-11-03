$(function () {
    if ($("#accuse").val() == "internal") {
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

    $(".rekTujuan").keyup(function (e) {
        $(".detailDst").val("").html("");
    });

    $(".nar").keyup(function (e) {
        this.value = this.value.replace(/[\*\?:]/g, "");
    });

    //Call ajax list jenis tx code
    jenisTrx();
});

function validateForm() {
    var result = "success";
    var branchDst = $("#branchDst").val();
    var cifDst = $("#cifDst").val();
    var suffixDst = $("#suffixDst").val();
    var extDst = $("#extDst").val();

    if ($("#myfile").val() == "") {
        result = "File upload kosong!";
        return result;
    }

    if ($("#accuse").val() == "internal") {
        if (branchDst == "" || cifDst == "" || suffixDst == "") {
            $("#branchDst,#cifDst,#suffixDst").css("background-color", "red");

            result = "Rekening Tujuan Tidak Boleh Kosong";
            return result;
        } else {
            $("#branchDst,#cifDst,#suffixDst").css("background-color", "");
        }
    } else {
        if (extDst == "") {
            $("#extDst").css("background-color", "red");

            result = "Rekening Tujuan Tidak Boleh Kosong";
            return result;
        } else {
            $("#extDst").css("background-color", "");
        }
    }

    if ($("#tipeDst").val() == "") {
        result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Tujuan";
        return result;
    }

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

function detailTujuan() {
    // alert('ds');
    var branch = $("#branchDst").val();
    var cif = $("#cifDst").val();
    var suffix = $("#suffixDst").val();
    var ext = $("#extDst").val();
    var accuse = $("#accuse").val();

    $("#nama_tujuan, #tipe_rek_tujuan, #tipe_ccy_tujuan").html("");
    $("#tipeDst, #namaDst, #ccyDst").val("");

    if (accuse == "internal") {
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
        $("#extDst").hide();
        $("#branchDst,#cifDst,#suffixDst").show();
        $("#accuse").val("internal");
    } else {
        $("#extDst").show();
        $("#branchDst,#cifDst,#suffixDst").hide();
        $("#accuse").val("external");
    }

    $("#branchDst,#cifDst,#suffixDst,#extDst").css("background-color", "");
}

function jenisTrx() {
    // alert("aa");

    $.ajax({
        url: "jenis-transaksi-kode",
        type: "GET",
        // data: "",
        success: function (data) {
            $(".loading-page").hide(); //show progress bar
            console.log(data);
            if (data.status == 200) {
                let dropdown = $("#getTrxList");
                dropdown.empty();
                dropdown.append('<option value="">- Pilih -</option>');

                data.listTrx.forEach(function (item) {
                    dropdown.append('<option value="' + item.trxName + '" data-dbcode="' + item.dbCode + '" data-crcode="' + item.crCode + '">' + item.trxName + "</option>");
                });

                // Set dbCode and crCode to input when dropdown changes
                dropdown.on("change", function () {
                    var selected = $(this).find("option:selected");
                    var dbCode = selected.data("dbcode") || "";
                    var crCode = selected.data("crcode") || "";
                    // alert(dbCode + ' - ' + crCode);
                    $("#dbCode").val(dbCode);
                    $("#crCode").val(crCode);
                });

                dropdown.trigger("change.select2");
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
