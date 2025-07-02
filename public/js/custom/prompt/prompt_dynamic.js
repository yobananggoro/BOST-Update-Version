// Modal List Rekening Start
var maxField = $("#dynamicField").val();

function listRekening(action) {
    // alert(action);
    var nama = $("#namaRekening").val();
    var cif = $("#cifRekening").val();
    var i = $("#paging").val() == "" ? 1 : parseInt($("#paging").val());
    var page = i;

    if (action == "next") {
        page = i + 1;
    } else if (action == "prev") {
        page = i - 1;
    } else {
        page = i;
    }

    $.ajax({
        url: "rekening-list?page=" + page,
        type: "GET",
        data: { nama: nama, cif: cif },
        cache: true,
        success: function (response) {
            // console.log(response.data);

            var table_data = "";
            $("#tableData").empty();

            for (var i = 0; i < response.data.length; i++) {
                table_data += '<tr onclick="getRowData(this)">';
                table_data += '<td class="text-center">' + (i + 1) + ".</td>";
                table_data += '<td class="nameAccount">' + response.data[i].nama + "</td>";
                table_data += '<td class="noAccount text-center">' + response.data[i].branch + "-" + response.data[i].cif + "-" + response.data[i].suffix + "</td>";
                table_data += '<td class="zlab" style="display:none">' + response.data[i].branch + "</td>";
                table_data += '<td class="zlan" style="display:none">' + response.data[i].cif + "</td>";
                table_data += '<td class="zlas" style="display:none">' + response.data[i].suffix + "</td>";
                table_data += '<td class="zlean text-center">' + response.data[i].externalNum + "</td>";
                table_data += '<td class="tipeAccount text-center">' + response.data[i].tipe_rek + "</td>";
                table_data += '<td class="tipeCcy text-center">' + response.data[i].tipe_ccy + "</td>";
                table_data += "</tr>";
            }

            $("#tableData").append(table_data);
            $("#halaman").html("Halaman ke : " + page);
            $("#paging").val(parseInt(page));

            if($('#paging').val() == null || $('#paging').val() < 2){
                // alert('a');
                $('#next').css('visibility', 'visible');
                $('#prev').css('visibility', 'hidden');
            } else {
                // alert('b');
                $('#prev').css('visibility', 'visible');
            }
        },
    });
}

function getRowData(element) {
    var zlab = $(element).find(".zlab").text();
    var zlan = $(element).find(".zlan").text();
    var zlas = $(element).find(".zlas").text();
    var zlean = $(element).find(".zlean").text();

    if ($("#trxtype").val() == "OTM") {
        if ($("#branchSrc").val() == "" || $("#cifSrc").val() == "" || $("#suffixSrc").val() == "" || $("#extSrc").val() == "") {
            $("#branchSrc").val(zlab);
            $("#cifSrc").val(zlan);
            $("#suffixSrc").val(zlas);
            $("#extSrc").val(zlean);
            $("#closeModal").click();
            $("#branchSrc").focus();
        } else {
            for (x = 1; x <= maxField; x++) {
                var form = document.getElementById("branchDst" + x);
                if (form != null) {
                    if ($("#branchDst" + x).val() == "" || $("#cifDst" + x).val() == "" || $("#suffixDst" + x).val() == "" || $("#extDst" + x).val() == "") {
                        // console.log('ada');
                        $("#branchDst" + x).val(zlab);
                        $("#cifDst" + x).val(zlan);
                        $("#suffixDst" + x).val(zlas);
                        $("#extDst" + x).val(zlean);
                        $("#closeModal").click();
                        $("#branchDst" + x).focus();
                        break;
                    } else {
                        continue;
                    }
                } else {
                    break;
                }
            }
        }
    } else {
        for (x = 1; x <= maxField; x++) {
            var form = document.getElementById("branchSrc" + x);
            if (form != null) {
                if ($("#branchSrc" + x).val() == "" || $("#cifSrc" + x).val() == "" || $("#suffixSrc" + x).val() == "" || $("#extSrc" + x).val() == "") {
                    $("#branchSrc" + x).val(zlab);
                    $("#cifSrc" + x).val(zlan);
                    $("#suffixSrc" + x).val(zlas);
                    $("#extSrc" + x).val(zlean);
                    $("#closeModal").click();
                    $("#branchSrc" + x).focus();
                    break;
                } else {
                    continue;
                }
            }

            if ($("#branchDst").val() == "" || $("#cifDst").val() == "" || $("#suffixDst").val() == "" || $("#extDst").val() == "") {
                $("#branchDst").val(zlab);
                $("#cifDst").val(zlan);
                $("#suffixDst").val(zlas);
                $("#extDst").val(zlean);
                $("#closeModal").click();
                $("#branchDst").focus();
            }
        }
    }
}

function paginate(id) {
    var action = id;
    listRekening(action);
}

function resetContent() {
    $("#tableData,#halaman").empty();
    $("#paging").empty().val("");
    $("#namaRekening,#cifRekening").val("");
}
// Modal List Rekening End
