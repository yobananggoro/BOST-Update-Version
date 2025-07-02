$(function() {
    function getCurrentDate(dt) {
        const d = dt !== undefined ? new Date(dt) : new Date(),
            year = d.getFullYear();
        let month = d.getMonth() + 1,
            day = d.getDate();
        if (month < 10) month = "0" + month;
        if (day < 10) day = "0" + day;

        return year + "-" + month + "-" + day;
    }

    if ($(".container-chart-pembukaan-rekening").length) {
        getChartPembukaanRekening(getCurrentDate);
    }

    $(".monthyearpick")
        .datepicker({
            autoclose: true,
            format: "yyyy-mm",
            viewMode: "months",
            minViewMode: "months"
        })
        .on("changeDate", function(e) {
            showLoading();
            getChartPembukaanRekening(getCurrentDate(e.date));
            $(".loading-page").fadeOut();
        });

    function getChartPembukaanRekening(periode) {
        $.post(
            BaseURI + "api/chartPembukaanRekening",
            { periode: periode },
            function(response) {
                const containerChart = $(".container-chart-pembukaan-rekening"),
                    msgChart = $(".message-chart-pembukaan-rekening"),
                    canvasChart = $("#chart-pembukaan-rekening");
                canvasChart.remove();
                msgChart.remove();
                if (typeof response === "object") {
                    containerChart.append(
                        '<canvas id="chart-pembukaan-rekening"></canvas>'
                    );
                    const chartCtx = $("#chart-pembukaan-rekening")
                        .get(0)
                        .getContext("2d");
                    const chart = new Chart(chartCtx, {
                        type: "line",
                        data: response,
                        options: {
                            responsive: true,
                            tooltips: {
                                mode: "index",
                                intersect: false
                            },
                            hover: {
                                mode: "nearest",
                                intersect: true
                            },
                            scales: {
                                xAxes: [
                                    {
                                        scaleLabel: {
                                            display: true,
                                            labelString: "Tanggal"
                                        }
                                    }
                                ],
                                yAxes: [
                                    {
                                        scaleLabel: {
                                            display: true,
                                            labelString: "Total"
                                        }
                                    }
                                ]
                            }
                        }
                    });
                } else {
                    containerChart.append(
                        '<div class="alert alert-warning message-chart-pembukaan-rekening">' +
                            response +
                            "</div>"
                    );
                }
            }
        );
    }

    restructure("kamusdata");

    $(document).on("click", "#generate-client-secret", function() {
        $.post(BaseURI + "api/generateClientSecret", function(response) {
            $('input[name="client_secret"]').val(response.data);
        });
    });

    toggleAlasanTolak($('select[name="approval"]').val());

    if ($('select[name="approval"]').length) {
        var approval = $('select[name="approval"]');
        toggleAlasanTolak(approval.val());
        approval.on("change", function() {
            toggleAlasanTolak(this.value);
        });
    }

    function toggleAlasanTolak(value) {
        let el = $('textarea[name="alasan_tolak"]');
        if (value != "" && value == 2) {
            el.parent()
                .parent()
                .show();
        } else {
            el.val("");
            el.parent()
                .parent()
                .hide();
        }
    }

    if ($("#table-invalid-data").length) {
        $("#table-invalid-data").DataTable({
            responsive: true,
            lengthChange: false
        });
    }

    if ($("#table-referensi-kode").length) {
        let table = $("#table-referensi-kode").DataTable({
            responsive: true,
            lengthChange: false,
            buttons: [
                {
                    extend: "pdf",
                    className: "btn-danger",
                    text:
                        '<i class="fas fa-file-excel"></i> Simpan sebagai PDF',
                    messageTop:
                        '<p class="text-center"><strong>Table Referensi Kode</strong></p>',
                    title: ""
                },
                {
                    extend: "print",
                    className: "btn-info",
                    text: '<i class="fas fa-print"></i> Cetak',
                    messageTop:
                        '<p class="text-center"><strong>Table Referensi Kode</strong></p>',
                    title: ""
                }
            ]
        });
        table
            .buttons()
            .container()
            .appendTo("#table-referensi-kode_wrapper .col-md-6:eq(0)");
    }

    if ($('select[name="gol_nasabah"]').length) {
        const optionFormatKamus = $('select[name="format_kamus"]');
        $('select[name="gol_nasabah"]').on("change", function() {
            if ($(this).val() == 2) {
                optionFormatKamus.val("GIRO");
            } else {
                optionFormatKamus.val("");
            }
        });
    }

    $(".format-buka-rekening").click(function() {
        showLoading();
        let cabang = $('select[name="unit_kerja_kode"]').val(),
            tipe = $('select[name="format_kamus"]').val(),
            url = $(this).prop("href") + "&cabang=" + cabang + "&t=" + tipe;
        if (tipe != "") {
            $.ajax({
                url: url,
                method: "post",
                xhrFields: { responseType: "blob" },
                success: function(data, status, xhr) {
                    if (xhr.status == 200) {
                        let disposition = xhr.getResponseHeader(
                                "content-disposition"
                            ),
                            matches = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/.exec(
                                disposition
                            ),
                            filename =
                                matches != null && matches[1]
                                    ? matches[1]
                                    : "file.pdf",
                            link = document.createElement("a"),
                            objUrl = window.URL.createObjectURL(data);
                        link.href = objUrl;
                        link.download = filename;
                        document.body.append(link);
                        link.click();
                        link.remove();
                        window.URL.revokeObjectURL(link);
                        $(".loading-page").fadeOut();
                    } else {
                        Swal.fire("Error", xhr.statusText, "error").then(
                            result => {
                                $(".loading-page").fadeOut();
                            }
                        );
                    }
                },
                error: function(xhr) {
                    Swal("Error", xhr.statusText, "error").then(result => {
                        $(".loading-page").fadeOut();
                    });
                }
            });
        } else {
            $(".loading-page").fadeOut();
            setTimeout(() => {
                Swal.fire(
                    "Error",
                    "Harap pilih Cabang terlebih dahulu",
                    "error"
                );
            }, 300);
        }
        return false;
    });

    if ($("#view-upload").length) {
        $(".scrollable-record-buka-rekening").hide();
    }

    $(document).on("click", "#view-upload", function(e) {
        e.preventDefault();
        showLoading();
        $("#view-upload").prop("disabled", true);
        $(".scrollable-record-buka-rekening").html("");
        let formData = false;
        if (window.FormData) {
            formData = new FormData($("form.form-data")[0]);
            $.ajax({
                url: BaseURI + "api/viewUploadBukaRekening",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.hasOwnProperty("data")) {
                        let data = response.data,
                            kamus = response.kamus,
                            elem = "",
                            record = 1;
                        data.forEach(function(item) {
                            elem +=
                                '<h4 class="bg-info p-2">Record #' +
                                record +
                                '</h4><div class="row">';
                            for (key in kamus) {
                                elem +=
                                    '<div class="col-md-6"><div class="row">' +
                                    '<div class="col-md-4">' +
                                    kamus[key] +
                                    "</div>" +
                                    '<div class="col-md-8">: ' +
                                    item[key] +
                                    "</div>" +
                                    "</div></div>";
                            }
                            elem += "</div><hr>";
                            ++record;
                        });
                        $(".scrollable-record-buka-rekening")
                            .append(elem)
                            .show();
                    }
                },
                error: function(response) {
                    let errors = JSON.parse(response.responseText).errors,
                        messages = [];
                    $.each(errors, function(key, error) {
                        messages.push(error);
                    });
                    toastr.error(messages.join("<br>"), "Error", {
                        closeButton: true,
                        preventDuplicates: true,
                        timeOut: 0,
                        extendedTimeOut: 0
                    });
                }
            });
        } else {
            toastr.warning(
                "Browser anda tidak dapat menampilkan Hasil Data Upload",
                "Error"
            );
        }
        setTimeout(() => {
            $("#view-upload").prop("disabled", false);
            $(".loading-page").fadeOut();
        }, 600);
    });
});
