$(function () {
    $("#btnApprove").click(function () {
        var isFinger = document.getElementById("isFinger").title;
        if (isFinger == "1") {
            var cek = validateForm();
            if (cek != "success") {
                alert(cek);
                return false;
            }
        }

        const userConfirmed = confirm("Apakah anda yakin?");

        if (userConfirmed) {
            alert("Jangan refresh/reload ketika sedang proses loading.");
            $(".loading-page").show();
            $("#btnApprove,#btnReject").hide();
            $("#approveBTN").click();
        }
    });

    $("#btnReject").click(function () {
        const userConfirmed = confirm("Apakah anda yakin?");

        if (userConfirmed) {
            $(".loading-page").show();
            $("#btnApprove,#btnReject").hide();
            $("#rejectBTN").click();
        }
    });
});

function validateForm() {
    var result = "success";

    if ($("#b64Finger").val() == "") {
        result = "Data Fingerprint Kosong!";
        return result;
    }

    return "success";
}
