$(function () { });

function cek() {
    var numbreff = $("#numbreff").val();
    var alur = confirm("Pada proses berlangsung disarankan untuk tidak reload/refresh web browser!");

    if (alur === true) {
        $(".loading-page").show();
        $.ajax({
            url: "cek-status-transaksi",
            type: "POST",
            data: { reff: numbreff },
            success: function (response) {
                $(".loading-page").hide(); //show progress bar
                // console.log(response);
                $(".toastrDefaultInfo").show(function () {
                    if (response.status == 200) {
                        if (response.data.responseCode == '00') {
                            toastr.info(response.data.responseCode + " | " + response.data.responseDesc);
                            $('#sttsTrx').html('Sukses');
                            $('#informasi_trx').html(response.data.responseDesc);
                            $('#kolom_status_trx_, #kolom_informasi_trx_, #btnStatus').hide();
                            $('#kolom_status_trx, #kolom_informasi_trx').show();
                        } else if (response.data.responseCode == '14') {
                            toastr.warning(response.data.responseCode + " | " + response.data.responseDesc);
                            $('#sttsTrx').html('Gagal');
                            $('#informasi_trx').html(response.data.responseDesc);
                            $('#kolom_status_trx_, #kolom_informasi_trx_, #btnStatus').hide();
                            $('#kolom_status_trx, #kolom_informasi_trx').show();
                        } else if (response.data.responseCode == '99') {
                            toastr.error(response.data.responseCode + " | " + response.data.data[0].message);
                            $('#sttsTrx').html('Gagal');
                            $('#informasi_trx').html(response.data.data[0].message);
                            $('#kolom_status_trx_, #kolom_informasi_trx_, #btnStatus').hide();
                            $('#kolom_status_trx, #kolom_informasi_trx').show();
                        } else { //rc 68
                            toastr.warning(response.data.responseCode + " | " + response.data.responseDesc);
                        }
                    } else {
                        toastr.error(response.status + " | " + response.data.message);
                    }
                });
            },
            error: function (error) {
                $(".loading-page").hide();
                $(".toastrDefaultError").show(function () {
                    toastr.error(error);
                });
            },
        });
    }
}

// function subm(data) {
//     // console.log(data);
//     // $("#formCekstatus").attr("target", "_self").submit();
//     // $(".loading-page").show();
// }


// if (data.data.responseCode == '00' || data.data.responseCode == '99') {
//     $("#msgStatus").val(JSON.stringify(data.data));
//     $("#rcStatus").val(data.data.responseCode);
//     // setTimeout(function () {
//     //     subm(data);
//     // }, 2000);
