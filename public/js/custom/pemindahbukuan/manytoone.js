$(function () {
    if ($("#accuseSrc1").val() == "internal") {
        $("#extSrc1").hide();
        $("#branchSrc1,#cifSrc1,#suffixSrc1").show();
    } else {
        $("#extSrc1").show();
        $("#branchSrc1,#cifSrc1,#suffixSrc1").hide();
    }

    if ($("#accuseDst").val() == "internal") {
        $("#extDst").hide();
        $("#branchDst,#cifDst,#suffixDst").show();
    } else {
        $("#extDst").show();
        $("#branchDst,#cifDst,#suffixDst").hide();
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

    $("#nominalDst_").keyup(function (e) {
        var nom = $("#nominalDst_").val();

        if (nom.length > 0) {
            $("#nominalDst").val(parseFloat(nom.replace(/,/g, "")));
        } else {
            $("#nominalDst").val("");
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

    $(".rekTujuan").keyup(function () {
        $(".detailDst").val("");
        $(".detailDst").html("");
    });

    $(document).on("keyup", ".rekSumber", function () {
        var regex = /\d+/g;
        var string = $(this).attr("id");
        var match = string.match(regex);
        // console.log(string.match(regex));

        $(".detailSrc" + match).val("");
        $(".detailSrc" + match).html("");
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
        $("#dynamicAddRemove").append('<div class="col-12" id="sumber' + i + '">' + '<input type="hidden" name="accuseSrc[]" id="accuseSrc' + i + '" value="internal">' + "<label>Rekening Sumber " + i + ' <span style="color: red">*</span></label>' + '<div class="row">' + '<div class="col-sm-8">' + '<div class="row col-sm-12">' + '<input type="text" name="extSrc[]" id="extSrc' + i + '" class="form-control number rekSumber" maxlength="13" placeholder="External Account">' + "</div>" + '<div class="row">' + '<div class="col-sm-4">' + '<input type="text" name="branchSrc[]" id="branchSrc' + i + '" class="form-control rekSumber number" maxlength="4" placeholder="Branch">' + "</div>" + '<div class="col-sm-4">' + '<input type="text" name="cifSrc[]" id="cifSrc' + i + '" class="form-control rekSumber ucase" maxlength="6" placeholder="CIF">' + "</div>" + '<div class="col-sm-4">' + '<input type="text" name="suffixSrc[]" id="suffixSrc' + i + '" class="form-control rekSumber number" maxlength="3" placeholder="Suffix">' + '<input type="hidden" name="tipeSrc[]" id="tipeSrc' + i + '" class="form-control detailSrc' + i + '" readonly>' + '<input type="hidden" name="namaSrc[]" id="namaSrc' + i + '" class="form-control detailSrc' + i + '" readonly>' + '<input type="hidden" name="ccySrc[]" id="ccySrc' + i + '" class="form-control detailSrc' + i + '" readonly>' + "</div>" + "</div>" + "</div>" + '<div class="col-sm-4">' + '<button type="button" class="btn btn-info" value="' + i + '" onclick="detailSumber(this);"><i class="fa fa-fw fa-info-circle"></i> Detail</button>&nbsp;' + '<button type="button" id="btnToogleSrc' + i + '" class="btn btn-secondary" onclick="toogle(this.id);" title="Toogle Form"><i class="fa fa-recycle"></i></button>' + "</div>" + '<div class="col-7" style="margin-top: 10px">' + '<input type="text" id="nominalSrc' + i + '" class="form-control currency text-right" onkeyup="nomsumber(this)" placeholder="Nominal Sumber ' + i + '">' + '<input type="hidden" id="nominalSrc' + i + '_" name="nominalSrc[]" class="form-control nomsumber text-right" readonly>' + "</div>" + "</div>" + '<table style="margin-left: 30px; margin-top: 10px">' + "<tr>" + '<td style="width: 110px; font-weight: bold">Nama Account</td>' + '<td> :&nbsp;&nbsp;</td><td id="nama_sumber' + i + '" class="detailSrc' + i + '"></td>' + "</tr>" + "<tr>" + '<td style="width: 110px; font-weight: bold">Tipe Account</td><td> :&nbsp;&nbsp;</td>' + '<td id="tipe_rek_sumber' + i + '" class="detailSrc' + i + '"></td>' + "</tr>" + "<tr>" + '<td style="width: 110px; font-weight: bold">Currency</td>' + "<td> :&nbsp;&nbsp;</td>" + '<td id="tipe_ccy_sumber' + i + '" class="detailSrc' + i + '"></td>' + "</tr>" + "</table><br>" + "</div>");
        $(".removeField").css("display", "");

        if ($("#accuseSrc" + i).val() == "internal") {
            $("#extSrc" + i).hide();
            $("#branchSrc" + i + ", #cifSrc" + i + ",#suffixSrc" + i).show();
        } else {
            $("#extSrc" + i).show();
            $("#branchSrc" + i + ", #cifSrc" + i + ", #suffixSrc" + i).hide();
        }

        ++i;
        return i;
    }
}

function deleteField() {
    var count = i - 1;
    $("#sumber" + count).remove();
    i--;
    total();

    if (i <= 2) {
        $(".removeField").css("display", "none");
    }

    return i;
}

function total() {
    //sum nominal rekening sumber
    var total = 0;
    $(".nomsumber").each(function () {
        total += parseInt($(this).val() - 0);
    });
    console.log(total);
    if (!isNaN(total)) {
        $("#total_").val(total.toFixed().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,"));
        $("#total").val(total == 0 ? "" : total);
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

function validateForm() {
    var result = "success";
    var branchDst = $("#branchDst").val();
    var cifDst = $("#cifDst").val();
    var suffixDst = $("#suffixDst").val();

    for (x = 1; x <= 10; x++) {
        var form = document.getElementById("branchSrc" + x);
        if (form != null) {
            if ($("#branchSrc" + x).val() == "" || $("#cifSrc" + x).val() == "" || $("#suffixSrc" + x).val() == "") {
                $("#branchSrc" + x).css("background-color", "red");
                $("#cifSrc" + x).css("background-color", "red");
                $("#suffixSrc" + x).css("background-color", "red");

                result = "Rekening Sumber " + x + " Tidak Boleh Kosong";
                return result;
            } else {
                $("#branchSrc" + x).css("background-color", "");
                $("#cifSrc" + x).css("background-color", "");
                $("#suffixSrc" + x).css("background-color", "");
            }

            if ($("#tipeSrc" + x).val() == "") {
                result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Sumber " + x + " ";
                return result;
            }

            if ($("#nominalSrc" + x).val() == "") {
                $("#nominalSrc" + x).css("background-color", "red");

                result = "Nominal Sumber " + x + " Tidak Boleh Kosong";
                return result;
            } else {
                $("#nominalSrc" + x).css("background-color", "");
            }

            if ($("#nominalSrc" + x).val() == 0) {
                $("#nominalSrc" + x).css("background-color", "red");

                result = "Nominal Sumber " + x + " Tidak Boleh diisi Angka 0!";
                return result;
            } else {
                $("#nominalSrc" + x).css("background-color", "");
            }
        }
    }

    if (branchDst == "" || cifDst == "" || suffixDst == "") {
        $("#branchDst, #cifDst, #suffixDst").css("background-color", "red");

        result = "Rekening Tujuan Tidak Boleh Kosong";
        return result;
    } else {
        $("#branchSrc, #cifSrc, #suffixSrc").css("background-color", "");
    }

    if ($("#tipDst").val() == "") {
        result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Tujuan";
        return result;
    }

    if ($("#nominalDst_").val() == "") {
        $("#nominalDst_").css("background-color", "red");

        result = "Nominal Tujuan Tidak Boleh Kosong";
        return result;
    } else {
        $("#nominalDst_").css("background-color", "");
    }

    if ($("#nominalDst").val() == 0) {
        $("#nominalDst_").css("background-color", "red");

        result = "Nominal Tujuan Tidak Boleh diisi Angka 0!";
        return result;
    } else {
        $("#nominalDst_").css("background-color", "");
    }

    if ($("#nominalDst").val() != $("#total").val()) {
        result = "Nominal Tujuan dan Total Nominal Sumber harus sama";
        return result;
    }

    return "success";
}

function detailSumber(val) {
    var branch = $("#branchSrc" + val.value).val();
    var cif = $("#cifSrc" + val.value).val();
    var suffix = $("#suffixSrc" + val.value).val();
    var ext = $("#extSrc" + val.value).val();
    var accuse = $("#accuseSrc" + val.value).val();
    var sqnc = val.value;

    $("#nama_sumber" + val.value).html("");
    $("#tipe_rek_sumber" + val.value).html("");
    $("#tipe_ccy_sumber" + val.value).html("");
    $("#tipeSrc" + val.value).val("");
    $("#namaSrc" + val.value).val("");
    $("#ccySrc" + val.value).val("");

    if (accuse == "internal") {
        if ($("#branchSrc" + sqnc).val().length < 4 || $("#cifSrc" + sqnc).val().length < 6 || $("#suffixSrc" + sqnc).val().length < 3) {
            $("#branchSrc" + sqnc + ",#cifSrc" + sqnc + ",#suffixSrc" + sqnc).css("background-color", "red");

            alert("Pastikan Branch CIF Suffix di Rekening Sumber " + sqnc + " sesuai ketentuan.");
            return false;
        } else {
            $("#branchSrc" + sqnc + ",#cifSrc" + sqnc + ",#suffixSrc" + sqnc).css("background-color", "");
        }
    } else {
        if (ext.length < 13) {
            $("#extSrc" + sqnc).css("background-color", "red");

            alert("Pastikan Rekening Eksternal di Rekening Sumber " + sqnc + " sesuai ketentuan.");
            return false;
        } else {
            $("#extSrc" + sqnc).css("background-color", "");
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
                    $("#nama_sumber" + val.value).html(data.accountShortName);
                    $("#tipe_rek_sumber" + val.value).html(data.accountType);
                    $("#tipe_ccy_sumber" + val.value).html(data.currency);

                    $("#branchSrc" + val.value).val(data.branch);
                    $("#cifSrc" + val.value).val(data.cif);
                    $("#suffixSrc" + val.value).val(data.suffix);
                    $("#extSrc" + val.value).val(data.externalAccountNumber);
                    $("#tipeSrc" + val.value).val(data.accountType);
                    $("#namaSrc" + val.value).val(data.accountShortName);
                    $("#ccySrc" + val.value).val(data.currency);

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
            console.log(error);

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
            console.log(data);

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
            $(".loading-page").hide();
            console.log(error);

            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });
        },
    });
}

function nomsumber(e) {
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
    if (id == "btnToogleDst") {
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
    } else {
        let numb = id.substring(12);
        // alert(numb);

        if ($("#accuseSrc" + numb).val() == "external") {
            $("#extSrc" + numb).hide();
            $("#branchSrc" + numb + ", #cifSrc" + numb + ", #suffixSrc" + numb).show();
            $("#accuseSrc" + numb).val("internal");
        } else {
            $("#extSrc" + numb).show();
            $("#branchSrc" + numb + ", #cifSrc" + numb + ", #suffixSrc" + numb).hide();
            $("#accuseSrc" + numb).val("external");
        }

        $("#branchSrc" + numb + ", #cifSrc" + numb + ", #suffixSrc" + numb + ", #extSrc" + numb).css("background-color", "");
    }
}
