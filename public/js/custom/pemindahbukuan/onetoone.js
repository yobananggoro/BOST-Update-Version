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
        this.value = this.value.replace(/[\*\?:]/g, "");
    });

    //Call ajax list usercode
    userCodeList();
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

    if ($("#beritaTrx").val() == "") {
        $("#beritaTrx").css("background-color", "red");

        result = "Berita Transaksi Tidak Boleh Kosong";
        return result;
    } else {
        $("#beritaTrx").css("background-color", "");
    }

    /* End validasi additional info apuppt */

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
    var ccyDst = $("#ccyDst").val();

    $("#nama_sumber,#tipe_rek_sumber,#tipe_ccy_sumber").html("");
    $("#tipeSrc,#namaSrc,#ccySrc").val("");

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
                    $("#ccy_amount").html(data.currency);

                    $("#branchSrc").val(data.branch);
                    $("#cifSrc").val(data.cif);
                    $("#suffixSrc").val(data.suffix);
                    $("#extSrc").val(data.externalAccountNumber);
                    $("#tipeSrc").val(data.accountType);
                    $("#namaSrc").val(data.accountShortName);
                    $("#ccySrc").val(data.currency);

                    if (ccyDst != "") {
                        getRates();
                    }

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

function detailTujuan() {
    var branch = $("#branchDst").val();
    var cif = $("#cifDst").val();
    var suffix = $("#suffixDst").val();
    var ext = $("#extDst").val();
    var accuse = $("#accuseDst").val();
    var ccySrc = $("#ccySrc").val();

    $("#nama_tujuan,#tipe_rek_tujuan,tipe_ccy_tujuan").html("");
    $("#tipeDst,#namaDst,#ccyDst").val("");

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

                    if (ccySrc != "") {
                        getRates();
                    }

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

function getRates() {
    var ccy_src = $("#ccySrc").val() || null;
    var ccy_dst = $("#ccyDst").val() || null;

    // console.log("getRates:", ccy_src, ccy_dst);

    $("#rates_fields").html("");
    $("#exchangeRate").val("");

    // Pastikan kedua nilai terisi dan berbeda
    if (!ccy_src || !ccy_dst || ccy_src === ccy_dst) return;

    // ✅ Jika salah satu IDR → cukup 1 kali panggilan
    if (ccy_src == "IDR" || ccy_dst == "IDR") {
        const currency = ccy_src == "IDR" ? ccy_dst : ccy_src;
        getSingleRate(currency, ccy_src, ccy_dst);
        return;
    }

    // ✅ Jika keduanya bukan IDR → panggil 2x (USD dan JPY misalnya)
    getSingleRate(ccy_src, ccy_src, "IDR"); // pertama: USD ke IDR
    getSingleRate(ccy_dst, ccy_dst, "IDR"); // kedua: JPY ke IDR
}

function getSingleRate(currency, ccy_src, ccy_dst) {
    $.ajax({
        url: "ccy-rates",
        type: "POST",
        data: { ccy: currency },
        success: function (data) {
            $(".loading-page").hide();
            if (data.status == 200) {
                const formatted_buy = new Intl.NumberFormat("en-US", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }).format(data.rates["exchangeRateBuy"]);

                const formatted_sell = new Intl.NumberFormat("en-US", {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2,
                }).format(data.rates["exchangeRateSell"]);

                // console.log(`✅ Rate fetched for ${currency}`, data.rates);

                if (ccy_src == "IDR" && ccy_dst != "IDR") {
                    valRates(formatted_sell, ccy_src, ccy_dst);
                } else if (ccy_src != "IDR" && ccy_dst == "IDR") {
                    valRates(formatted_buy, ccy_src, ccy_dst);
                } else {
                    valRates(formatted_buy, currency, "IDR");
                }
            }
        },
        error: function (error) {
            $(".loading-page").hide();
            toastr.error("Gagal ambil rate untuk " + currency);
        },
    });
}

function valRates(e, ccy1, ccy2) {
    var i = 1;
    const noSeparator = e.replace(/,/g, "");
    if (i <= 2) {
        $("#exchangeRate").val(noSeparator);
        $("#rates_fields").append('<div id="fieldRates" class="col-12 form-group"><label>Rate ' + ccy1 + " / " + ccy2 + ' </label><input type="text" class="form-control text-right" value="' + e + '" disabled></div>');
        ++i;
        return i;
    } else {
        $("#fieldRates").remove();
        i--;
        return i;
    }
}

function userCodeList() {
    // alert("aa");

    $.ajax({
        url: "user-code-list",
        type: "GET",
        // data: "",
        success: function (data) {
            $(".loading-page").hide(); //show progress bar
            // console.log(data);
            if (data.status == 200) {
                let dropdown = $("#getUserCodeList");
                dropdown.empty();
                dropdown.append('<option value="">- Pilih -</option>');

                data.listTrx.forEach(function (item) {
                    dropdown.append('<option value="' + item.description + '" data-first="' + item.userCode1 + '" data-second="' + item.userCode2 + '">' + item.description + "</option>");
                });

                // Set dbCode and crCode to input when dropdown changes
                dropdown.on('change', function () {
                    var selected = $(this).find('option:selected');
                    var usrCodeFirst = selected.data('first') || '';
                    var usrCodeSecond = selected.data('second') || '';
                    // alert(usrCodeFirst + ' - ' + usrCodeSecond);
                    $('#userCode1').val(usrCodeFirst);
                    $('#userCode2').val(usrCodeSecond);
                });

                dropdown.trigger('change.select2');
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
