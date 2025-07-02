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
            console.log(data);
            if (data.status == 200) {
                if (data.code == "00") {
                    $("#cust").html(data.cif);
                    $("#cust_name").html(data.accountShortName);

                    $("#branch").val(data.branch);
                    $("#cif,#cif_cust").val(data.cif);
                    $("#suffix").val(data.suffix);
                    $("#ext").val(data.externalAccountNumber);
                    $("#cif_name").val(data.accountShortName);

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
        var sr = $(this).attr("src");
        var imgID = $(this).data("id");

        $(this).mousemove(function (evt) {
            $("#zoomArea_" + imgID)
                .css("top", evt.clientY + 10)
                .css("left", evt.clientX + 10);
        });

        $(this).hover(
            function (evt) {
                const zoomImg = $("#zoomImg_" + imgID);
                if (zoomImg.attr("src") === "") {
                    zoomImg.attr("src", sr);
                }
                $("#zoomArea_" + imgID)
                    .css("top", evt.clientY + 10)
                    .css("left", evt.clientX + 10)
                    .fadeIn("fast");
            },
            function () {
                $("#zoomArea_" + imgID).fadeOut("fast");
            }
        );
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
