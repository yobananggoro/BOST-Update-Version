$(function () {
    jenisTrx();
    initDataTable();
});

function initDataTable() {
    if (typeof $.fn.DataTable === 'undefined') return;

    if ($('#dataTable1').length) {
        $('#dataTable1').DataTable();
    }

    if ($('#dataTable2').length) {
        $('#dataTable2').DataTable({
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
    // alert("aa");

    $.ajax({
        url: "jenis-transaksi-kode",
        type: "GET",
        // data: "",
        success: function (data) {
            $(".loading-page").hide(); //show progress bar
            // console.log(data);
            if (data.status == 200) {
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
