$(function () {
    if ($("#accuse").val() == "internal") {
        $("#ext").hide();
        $("#branch,#cif,#suffix").show();
    } else {
        $("#ext").show();
        $("#branch,#cif,#suffix").hide();
    }

    $("#cust").html($("#cif_cust").val());
    $("#cust_name").html($("#cif_name").val());
    $("#account_type").html($("#cif_type").val());

    $("#btnEnter").click(function () {
        // alert('das');
        var cek = validateForm();
        if (cek != "success") {
            alert(cek);
            return false;
        }
        $(".loading-page").show();
        $("#formAccount").attr("target", "_self").submit();
    });

    makeZoom();
});

function toogle(id) {
    if ($("#accuse").val() == "external") {
        $("#ext").hide();
        $("#branch,#cif,#suffix").show();
        $("#accuse").val("internal");
    } else {
        $("#ext").show();
        $("#branch,#cif,#suffix").hide();
        $("#accuse").val("external");
    }

    $("#branch,#cif,#suffix,#ext").css("background-color", "");
}

function detail() {
    var branch = $("#branch").val();
    var cif = $("#cif").val();
    var suffix = $("#suffix").val();
    var ext = $("#ext").val();
    var accuse = $("#accuse").val();

    if (accuse == "internal") {
        if (branch.length < 4 || cif.length < 6 || suffix.length < 3) {
            $("#branch,#cif,#suffix").css("background-color", "red");

            alert("Pastikan Branch CIF Suffix sesuai ketentuan.");
            return false;
        } else {
            $("#branch,#cif,#suffix").css("background-color", "");
        }
    } else {
        if (ext.length < 13) {
            $("#ext").css("background-color", "red");

            alert("Pastikan Rekening Eksternal sesuai ketentuan.");
            return false;
        } else {
            $("#ext").css("background-color", "");
        }
    }

    $(".loading-page").show(); //show progress bar

    $.ajax({
        url: "account-gi",
        type: "POST",
        data:
            accuse == "internal"
                ? {
                      branch: branch,
                      cif: cif,
                      suffix: suffix,
                  }
                : {
                      extAcctNumber: ext,
                  },
        success: function (data) {
            $(".loading-page").hide(); //show progress bar
            // console.log(data);
            if (data.status == 200) {
                if (data.code == "00") {
                    $("#cust").html(data.cif);
                    $("#cust_name").html(data.accountShortName);
                    $("#account_type").html(data.accountType);

                    $("#branch").val(data.branch);
                    $("#cif,#cif_cust").val(data.cif);
                    $("#suffix").val(data.suffix);
                    $("#ext").val(data.externalAccountNumber);
                    $("#cif_name").val(data.accountShortName);
                    $("#cif_type").val(data.accountType);
                    

                    $(".toastrDefaultInfo").show(function () {
                        toastr.info("Data ditemukan!");
                    });
                } else {
                    // alert("99");
                    $(".toastrDefaultError").show(function () {
                        toastr.error(data.msgdesc);
                    });
                }
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

function makeZoom() {
    $(".imgThumb").each(function () {
        const $thumb = $(this);
        const imgID = $thumb.data("id");
        const src = $thumb.attr("src");

        const $zoomArea = $("#zoomArea_" + imgID);
        const $zoomImg = $("#zoomImg_" + imgID);

        const offset = 20; // JARAK BAWAH CURSOR

        $thumb.on("mouseenter", function (e) {
            if (!$zoomImg.attr("src")) {
                $zoomImg.attr("src", src);
            }
            $zoomArea.show();
        });

        $thumb.on("mousemove", function (e) {
            let x = e.clientX;
            let y = e.clientY + offset; // ⬅️ DI BAWAH CURSOR

            // 🧱 batas bawah layar
            if (y + $zoomArea.outerHeight() > window.innerHeight) {
                y = e.clientY - $zoomArea.outerHeight() - offset;
            }

            // 🧱 batas kanan layar
            if (x + $zoomArea.outerWidth() > window.innerWidth) {
                x = window.innerWidth - $zoomArea.outerWidth() - 10;
            }

            $zoomArea.css({
                left: x + "px",
                top: y + "px",
            });
        });

        $thumb.on("mouseleave", function () {
            $zoomArea.hide();
        });
    });
}

function validateForm() {
    var result = "success";
    var cif = $("#cif_cust").val();

    if ($("#cif_cust").val() == "") {
        result = "Customer tidak boleh kosong!";
        return result;
    }

    return "success";
}
