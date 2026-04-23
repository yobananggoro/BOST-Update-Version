$(function () {
    // Konfigurasi untuk setiap dropdown
    const dropdownConfig = [
        {
            groupCode: "instrument_code",
            dropdownId: "#getInstrumenList",
            textId: "#getInstrumentText",
            divId: "instrumenLain",
            fieldName: "instrumenLainnya",
            triggerKeyCode: 99,
            overlayId: "#instrumenOverlay"
        },
        {
            groupCode: "klasifikasi_trx_code",
            dropdownId: "#getKlasifikasiList",
            textId: "#getKlasifikasiText",
            divId: "klasifikasiLain",
            fieldName: "klasifikasiLainnya",
            triggerKeyCode: 99,
            overlayId: "#klasifikasiOverlay"
        },
        {
            groupCode: "kepentingan_trx_code",
            dropdownId: "#getKepentinganList",
            textId: "#getKepentinganText",
            divId: "kepentinganLain",
            fieldName: "kepentinganLainnya",
            triggerKeyCode: 99,
            overlayId: "#kepentinganOverlay"
        },
        {
            groupCode: "sumberdana_code",
            dropdownId: "#getSumberDanaList",
            textId: "#getSumberDanaText",
            divId: "sumberDanaLain",
            fieldName: "sumberDanaLainnya",
            triggerKeyCode: 9,
            overlayId: "#sumberDanaOverlay"
        },
        {
            groupCode: "tujuan_trx_code",
            dropdownId: "#getTujuanList",
            textId: "#getTujuanText",
            divId: "tujuanLain",
            fieldName: "tujuanLainnya",
            triggerKeyCode: 9,
            overlayId: "#tujuanOverlay"
        }
    ];

    // Setup select2 dan event untuk setiap dropdown
    dropdownConfig.forEach(config => {
        $(config.dropdownId).select2({
            placeholder: "- Pilih -",
            allowClear: true,
        });

        $(config.dropdownId).one("select2:open", function () {
            loadDropdown(config);
        });
    });
});

function loadDropdown(config) {
    let dropdown = $(config.dropdownId);
    dropdown.prop("disabled", true);
    $(config.overlayId).css("display", "flex");

    $.ajax({
        url: "kodefikasi-list",
        type: "POST",
        data: { groupCode: config.groupCode },
        success: function (data) {
            if (data.status == 200) {
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
                dropdown.prop("disabled", false).trigger("change");
                $(config.overlayId).hide();
                setTimeout(function () {
                    dropdown.select2('open');
                }, 50);
            } else {
                dropdown.prop("disabled", false);
                $(config.overlayId).hide();
                $(".toastrDefaultError").show(function () {
                    toastr.error(data.message);
                });
            }
        },
        error: function (error) {
            dropdown.prop("disabled", false).trigger("change");
            $(config.overlayId).hide();
            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });
        },
    });
}
