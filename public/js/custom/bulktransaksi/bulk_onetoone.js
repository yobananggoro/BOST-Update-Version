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
});

function validateForm() {
    var result = "success";

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
