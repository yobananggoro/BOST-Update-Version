$(function () {
    // Konfigurasi untuk setiap dropdown
    const dropdownConfig = [
        {
            groupCode: "instrument_code",
            dropdownId: "#getInstrumenList",
            textId: "#getInstrumentText",
            divId: "instrumenLain",
            fieldName: "instrumenLainnya",
            triggerKeyCode: 99
        },
        {
            groupCode: "klasifikasi_trx_code",
            dropdownId: "#getKlasifikasiList",
            textId: "#getKlasifikasiText",
            divId: "klasifikasiLain",
            fieldName: "klasifikasiLainnya",
            triggerKeyCode: 99
        },
        {
            groupCode: "kepentingan_trx_code",
            dropdownId: "#getKepentinganList",
            textId: "#getKepentinganText",
            divId: "kepentinganLain",
            fieldName: "kepentinganLainnya",
            triggerKeyCode: 99
        },
        {
            groupCode: "sumberdana_code",
            dropdownId: "#getSumberDanaList",
            textId: "#getSumberDanaText",
            divId: "sumberDanaLain",
            fieldName: "sumberDanaLainnya",
            triggerKeyCode: 9
        },
        {
            groupCode: "tujuan_trx_code",
            dropdownId: "#getTujuanList",
            textId: "#getTujuanText",
            divId: "tujuanLain",
            fieldName: "tujuanLainnya",
            triggerKeyCode: 9
        }
    ];

    // Load semua dropdown
    dropdownConfig.forEach(config => initializeDropdown(config));
});

function initializeDropdown(config) {
    $.ajax({
        url: "kodefikasi-list",
        type: "POST",
        data: { groupCode: config.groupCode },
        success: function (data) {
            if (data.status == 200) {
                let dropdown = $(config.dropdownId);
                dropdown.empty();
                dropdown.append('<option value="">- Pilih -</option>');

                data.data.forEach(function (item) {
                    dropdown.append('<option data-keycode="' + item.keyCode + '" data-desc="' + item.description + '" value="' + item.keyCode + '">' + item.value + "</option>");
                });

                dropdown.on("change", function () {
                    var selected = $(this).find("option:selected");
                    var keyCode = selected.data("keycode") || "";
                    let freetext = $(config.textId);

                    if (keyCode == config.triggerKeyCode) {
                        freetext.empty();
                        freetext.append('<div id="' + config.divId + '" style="margin-top: 10px"><input class="form-control" id="' + config.fieldName + '" name="' + config.fieldName + '"></div>');
                    } else {
                        $("#" + config.divId).remove();
                    }
                });

                dropdown.trigger("change.select2");
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
