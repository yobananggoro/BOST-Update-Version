$(function () {
    if ($("#accuseSrc").val() == "internal") {
        $("#extSrc").hide();
        $("#branchSrc,#cifSrc,#suffixSrc").show();
    } else {
        $("#extSrc").show();
        $("#branchSrc,#cifSrc,#suffixSrc").hide();
    }

    if ($("#accuseDst1").val() == "internal") {
        $("#extDst1").hide();
        $("#branchDst1,#cifDst1,#suffixDst1").show();
    } else {
        $("#extDst1").show();
        $("#branchDst1,#cifDst1,#suffixDst1").hide();
    }

    $("input[name$='group1']").click(function () {
        var test = $(this).val();

        $("div.sumber").hide();
        $("#rek" + test).show();
    });

    $("input[name$='group2']").click(function () {
        var test = $(this).val();

        $("div.tujuan").hide();
        $("#rek" + test).show();
    });

    $(".number-separator").keypress(function (e) {
        if (/^-?\d*[,.]?(\d{0,3},)*(\d{3},)?\d{0,3}$/.test(e.key)) {
            $(".number-separator").on("input", function () {
                e.target.value = numberSeparator(e.target.value);
            });
        } else {
            e.preventDefault();
            return false;
        }
    });

    $("#nominalSrc_").keyup(function (e) {
        var nom = $("#nominalSrc_").val();

        // $('#nominalSrc').val(parseFloat(nom.replace(/,/g, "")));
        if (nom.length > 0) {
            $("#nominalSrc").val(parseFloat(nom.replace(/,/g, "")));
        } else {
            $("#nominalSrc").val("");
        }
    });

    $("#btnEnter").click(function (e) {
        var cek = validateForm();
        if (cek != "success") {
            alert(cek);
            return false;
        }

        $(".loading-page").show();
        // $("#formAccount").attr('target', '_self').submit();
    });

    $("#listRekening").click(function () {
        // resetContent()
    });

    $(".rekSumber").keyup(function (e) {
        $(".detailSrc").val("");
        $(".detailSrc").html("");
    });

    $(document).on("keyup", ".rekTujuan", function () {
        var regex = /\d+/g;
        var string = $(this).attr("id");
        var match = string.match(regex);

        // console.log(string.match(regex));

        $(".detailDst" + match).val("");
        $(".detailDst" + match).html("");
    });

    $(".nar").keyup(function (e) {
        this.value = this.value.replace(/[\*\?:]/g, "");
    });
});

var i = 2;
var maxField = $("#dynamicField").val();
function dynamicField() {
    var max = maxField;

    if (i <= max) {
        $("#dynamicAddRemove").append('<div class="col-12" id="tujuan' + i + '">' + '<input type="hidden" name="accuseDst[]" id="accuseDst' + i + '" value="internal">' + "<label>Rekening Tujuan " + i + ' <span style="color: red">*</span></label>' + '<div class="row">' + '<div class="col-sm-8">' + '<div class="row col-sm-12">' + '<input type="text" name="extDst[]" id="extDst' + i + '" class="form-control number rekTujuan" maxlength="13" placeholder="External Account">' + "</div>" + '<div class="row">' + '<div class="col-sm-4">' + '<input type="text" name="branchDst[]" id="branchDst' + i + '" class="form-control rekTujuan number" maxlength="4" placeholder="Branch">' + "</div>" + '<div class="col-sm-4">' + '<input type="text" name="cifDst[]" id="cifDst' + i + '" class="form-control rekTujuan ucase" maxlength="6" placeholder="CIF">' + "</div>" + '<div class="col-sm-4">' + '<input type="text" name="suffixDst[]" id="suffixDst' + i + '" class="form-control rekTujuan number" maxlength="3" placeholder="Suffix">' + '<input type="hidden" name="tipeDst[]" id="tipeDst' + i + '" class="form-control detailDst' + i + '" readonly>' + '<input type="hidden" name="namaDst[]" id="namaDst' + i + '" class="form-control detailDst' + i + '" readonly>' + '<input type="hidden" name="ccyDst[]" id="ccyDst' + i + '" class="form-control detailDst' + i + '" readonly>' + "</div>" + "</div>" + "</div>" + '<div class="col-sm-4">' + '<button type="button" class="btn btn-info" value="' + i + '" onclick="detailTujuan(this);"><i class="fa fa-fw fa-info-circle"></i> Detail</button>&nbsp;' + '<button type="button" id="btnToogleDst' + i + '" class="btn btn-secondary" onclick="toogle(this.id);" title="Toogle Form"><i class="fa fa-recycle"></i></button>' + "</div>" + '<div class="col-7" style="margin-top: 10px">' + '<input type="text" id="nominalDst' + i + '" class="form-control currency text-right" onkeyup="nomtujuan(this)" placeholder="Nominal Tujuan ' + i + '">' + '<input type="hidden" id="nominalDst' + i + '_" name="nominalDst[]" class="form-control nomtujuan text-right" readonly>' + "</div>" + "</div>" + '<table style="margin-left: 30px; margin-top: 10px">' + "<tr>" + '<td style="width: 150px; font-weight: bold">Nama Rekening</td>' + '<td> :&nbsp;&nbsp;</td><td id="nama_tujuan' + i + '" class="detailDst' + i + '"></td>' + "</tr>" + "<tr>" + '<td style="width: 110px; font-weight: bold">Tipe Rekening</td><td> :&nbsp;&nbsp;</td>' + '<td id="tipe_rek_tujuan' + i + '" class="detailDst' + i + '"></td>' + "</tr>" + "<tr>" + '<td style="width: 110px; font-weight: bold">Mata Uang</td>' + "<td> :&nbsp;&nbsp;</td>" + '<td id="tipe_ccy_tujuan' + i + '" class="detailDst' + i + '"></td>' + "</tr>" + "</table><br>" + "</div>");
        $(".removeField").css("display", "");

        if ($("#accuseDst" + i).val() == "internal") {
            $("#extDst" + i).hide();
            $("#branchDst" + i + ", #cifDst" + i + ",#suffixDst" + i).show();
        } else {
            $("#extDst" + i).show();
            $("#branchDst" + i + ", #cifDst" + i + ", #suffixDst" + i).hide();
        }

        ++i;
        return i;
    }
}

function deleteField() {
    var count = i - 1;
    $("#tujuan" + count).remove();
    i--;
    total();

    if (i <= 2) {
        $(".removeField").css("display", "none");
    }

    return i;
}

function total() {
    //sum nominal rekening tujuan
    var total = 0;
    $(".nomtujuan").each(function () {
        total += parseInt($(this).val() - 0);
    });
    // console.log(total);
    if (!isNaN(total)) {
        $("#total_").val(total.toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
        $("#total").val(total);
    }
}

function komparasi() {
    //membandingkan isian form total nominal

    let rekSumber = $("#tipe_sumber").val();
    let nomSumber = $("#nomsumber").val();
    let nomTujuan = $("#total").val();

    if (!rekSumber) {
        alert("Silahkan isi Rekening Sumber");
    } else if (!nomSumber) {
        alert("Silahkan isi Nominal Sumber");
    } else if (!nomTujuan) {
        alert("Silahkan isi Nominal Tujuan!");
    } else {
        if (nomSumber === nomTujuan) {
            $("#validate, #reff").show();
        } else {
            alert("Jumlah Nonimal Sumber dan Total Nonimal Sumber harus sama!");
            $("#validate, #reff").hide();
        }
    }
}

function numberSeparator(Number) {
    var commaCounter = 10;
    Number += "";

    for (var i = 0; i < commaCounter; i++) {
        Number = Number.replace(",", "");
    }

    x = Number.split(".");
    y = x[0];
    z = x.length > 1 ? "." + x[1] : "";
    var rgx = /(\d+)(\d{3})/;

    while (rgx.test(y)) {
        y = y.replace(rgx, "$1" + "," + "$2");
    }
    commaCounter++;
    return y + z;
}

function validasiLimit() {
    var nominal = parseInt(document.getElementById("nomsumber").value);
    var limit = parseInt(document.getElementById("limit").value);
    var status = document.getElementById("status").value;

    if (status != "Success") {
        alert("Transaksi tidak dapat dilakukan!");
    } else {
        if (nominal > limit) {
            alert("Nominal melebihi ketentuan limit, silahkan lakukan otorisasi!");
            $("#otorisasi").show();
            $("#subm").show();
            $("#verified").hide();
        } else {
            $("#verified").hide();
            $("#subm").show();
        }
    }
}

function validateForm() {
    var result = "success";
    var branchSrc = $("#branchSrc").val();
    var cifSrc = $("#cifSrc").val();
    var suffixSrc = $("#suffixSrc").val();

    //Kolom Rekening Sumber Start
    if ($("#accuseSrc").val() == "internal") {
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

    for (x = 1; x <= 10; x++) {
        var form = document.getElementById("branchDst" + x);
        if (form != null) {
            if ($("#branchDst" + x).val() == "" || $("#cifDst" + x).val() == "" || $("#suffixDst" + x).val() == "") {
                $("#branchDst" + x).css("background-color", "red");
                $("#cifDst" + x).css("background-color", "red");
                $("#suffixDst" + x).css("background-color", "red");

                result = "Rekening Tujuan " + x + " Tidak Boleh Kosong";
                return result;
            } else {
                $("#branchDst" + x).css("background-color", "");
                $("#cifDst" + x).css("background-color", "");
                $("#suffixDst" + x).css("background-color", "");
            }

            if ($("#tipeDst" + x).val() == "") {
                result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Tujuan " + x + " ";
                return result;
            }

            if ($("#nominalDst" + x).val() == "") {
                $("#nominalDst" + x).css("background-color", "red");

                result = "Nominal Tujuan " + x + " Tidak Boleh Kosong";
                return result;
            } else {
                $("#nominalDst" + x).css("background-color", "");
            }

            if ($("#nominalDst" + x).val() == 0) {
                $("#nominalDst" + x).css("background-color", "red");

                result = "Nominal Tujuan " + x + " Tidak Boleh diisi Angka 0!";
                return result;
            } else {
                $("#nominalDst" + x).css("background-color", "");
            }
        }
    }

    if ($("#nominalSrc_").val() == "") {
        $("#nominalSrc_").css("background-color", "red");

        result = "Nominal Sumber Tidak Boleh Kosong";
        return result;
    } else {
        $("#nominalSrc_").css("background-color", "");
    }

    if ($("#nominalSrc").val() == 0) {
        $("#nominalSrc_").css("background-color", "red");

        result = "Nominal Sumber Tidak Boleh diisi Angka 0!";
        return result;
    } else {
        $("#nominalSrc_").css("background-color", "");
    }

    if ($("#nominalSrc").val() != $("#total").val()) {
        result = "Nominal Sumber dan Total Nominal Tujuan harus sama";
        return result;
    }

    return "success";
}

function detailSumber() {
    // alert('ds');
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
            console.log(data);

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
            console.log(error);

            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });
        },
    });
}

function detailTujuan(val) {
    var branch = $("#branchDst" + val.value).val();
    var cif = $("#cifDst" + val.value).val();
    var suffix = $("#suffixDst" + val.value).val();
    var ext = $("#extDst" + val.value).val();
    var accuse = $("#accuseDst" + val.value).val();
    var sqnc = val.value;

    $("#nama_tujuan" + val.value).html("");
    $("#tipe_rek_tujuan" + val.value).html("");
    $("#tipe_ccy_tujuan" + val.value).html("");
    $("#tipeDst" + val.value).val("");
    $("#namaDst" + val.value).val("");
    $("#ccyDst" + val.value).val("");

    if (accuse == "internal") {
        if ($("#branchDst" + sqnc).val().length < 4 || $("#cifDst" + sqnc).val().length < 6 || $("#suffixDst" + sqnc).val().length < 3) {
            $("#branchDst" + sqnc + ",#cifDst" + sqnc + ",#suffixDst" + sqnc).css("background-color", "red");

            alert("Pastikan Branch CIF Suffix di Rekening Tujuan " + sqnc + " sesuai ketentuan.");
            return false;
        } else {
            $("#branchDst" + sqnc + ",#cifDst" + sqnc + ",#suffixDst" + sqnc).css("background-color", "");
        }
    } else {
        if (ext.length < 13) {
            $("#extDst" + sqnc).css("background-color", "red");

            alert("Pastikan Rekening Eksternal di Rekening Tujuan " + sqnc + " sesuai ketentuan.");
            return false;
        } else {
            $("#extDst" + sqnc).css("background-color", "");
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
            console.log(data);
            if (data.status == 200) {
                if (data.code == "00") {
                    $("#nama_tujuan" + val.value).html(data.accountShortName);
                    $("#tipe_rek_tujuan" + val.value).html(data.accountType);
                    $("#tipe_ccy_tujuan" + val.value).html(data.currency);

                    $("#branchDst" + val.value).val(data.branch);
                    $("#cifDst" + val.value).val(data.cif);
                    $("#suffixDst" + val.value).val(data.suffix);
                    $("#extDst" + val.value).val(data.externalAccountNumber);
                    $("#tipeDst" + val.value).val(data.accountType);
                    $("#namaDst" + val.value).val(data.accountShortName);
                    $("#ccyDst" + val.value).val(data.currency);

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
            } else if (data.status == 500) {
                $(".toastrDefaultError").show(function () {
                    toastr.error(data.message);
                });
            } else if (data.status == 400) {
                $(".toastrDefaultError").show(function () {
                    toastr.error(data.message);
                });
            } else {
                $(".toastrDefaultError").show(function () {
                    toastr.error(data.message);
                });
            }
        },
        error: function (error) {
            $(".loading-page").hide(); //hide progress bar
            console.log(error);

            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });
        },
    });
}

function nomtujuan(e) {
    var nom = $("#" + e.id).val();

    // $('#'+e.id+'_').val(parseFloat(nom.replace(/,/g, "")));
    if (nom.length > 0) {
        $("#" + e.id + "_").val(parseFloat(nom.replace(/,/g, "")));
    } else {
        $("#" + e.id + "_").val("");
    }

    total();
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
        let numb = id.substring(12);
        // alert(numb);

        if ($("#accuseDst" + numb).val() == "external") {
            $("#extDst" + numb).hide();
            $("#branchDst" + numb + ", #cifDst" + numb + ", #suffixDst" + numb).show();
            $("#accuseDst" + numb).val("internal");
        } else {
            $("#extDst" + numb).show();
            $("#branchDst" + numb + ", #cifDst" + numb + ", #suffixDst" + numb).hide();
            $("#accuseDst" + numb).val("external");
        }

        $("#branchDst" + numb + ", #cifDst" + numb + ", #suffixDst" + numb + ", #extDst" + numb).css("background-color", "");
    }
}
