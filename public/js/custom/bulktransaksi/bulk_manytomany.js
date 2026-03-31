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
