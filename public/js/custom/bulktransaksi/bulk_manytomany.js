$(function () {
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

    if ($("#myfile").val() == "") {
        $("#myfile").css("background-color", "red");

        result = "Upload Bulk File Tidak Boleh Kosong";
        return result;
    } else {
        $("#myfile").css("background-color", "");
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

        result = "Nominal Tidak Boleh diisi Angka 0";
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
