$(function () {
    initDataTable();
    $("#getTrxList").select2({ placeholder: "- Pilih -", allowClear: true }).one("select2:open", jenisTrx);
});

function initDataTable() {
    if (typeof $.fn.DataTable === "undefined") return;

    if ($("#dataTable1").length) {
        $("#dataTable1").DataTable();
    }

    if ($("#dataTable2").length) {
        $("#dataTable2").DataTable({
            paging: true,
            lengthChange: false,
            searching: true,
            ordering: true,
            info: true,
            autoWidth: true,
        });
    }
}

function jenisTrx() {
    let dropdown = $("#getTrxList");
    dropdown.prop("disabled", true);
    $("#jenisTrxOverlay").css("display", "flex");

    $.ajax({
        url: "jenis-transaksi-kode",
        type: "GET",
        // data: "",
        success: function (data) {
            $(".loading-page").hide(); //show progress bar
            // console.log(data);
            if (data.status == 200) {
                $(".toastrDefaultInfo").show(function () {
                    toastr.info("Jenis Transaksi ready!");
                });

                let dropdown = $("#getTrxList");
                dropdown.empty();
                dropdown.append('<option value="">- Pilih -</option>');

                data.listTrx.forEach(function (item) {
                    dropdown.append('<option value="' + item.trxName + '" data-dbcode="' + item.dbCode + '" data-crcode="' + item.crCode + '">' + item.trxName + " [" + item.dbCode + " - " + item.crCode + "]</option>");
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
                dropdown.prop("disabled", false).trigger("change");
                $("#jenisTrxOverlay").hide();
                setTimeout(function () {
                    dropdown.select2("open");
                }, 50);
            } else {
                dropdown.prop("disabled", false);
                $("#jenisTrxOverlay").hide();
                $(".toastrDefaultError").show(function () {
                    toastr.error(data.message);
                });
            }
        },
        error: function (error) {
            dropdown.prop("disabled", false);
            $("#jenisTrxOverlay").hide();
            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });
        },
    });
}

function handleSwitch(element, id) {
    let isChecked = element.checked;
    let flagValue = isChecked ? "on" : "off";

    $.ajax({
        url: "flag-jenistransaksi",
        type: "POST",
        data: {
            id: id,
            flag: flagValue,
        },
        success: function (data) {
            $(".toastrDefaultInfo").show(function () {
                toastr.info("Updated");
            });
        },
        error: function (error) {
            $(".loading-page").hide();
            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });

            element.checked = !isChecked;
        },
    });
}
