$(function () {
    $("#btnEnter").click(function () {
        // alert('das');
        var cek = validateForm();
        if (cek != "success") {
            alert(cek);
            return false;
        }
        const userConfirmed = confirm("Apakah anda yakin data sudah sesuai?");

        if (userConfirmed) {
            $(".loading-page").show();
            $("#formAccount").attr("target", "_self").submit();
        }
    });
});

function validateForm() {
    var result = "success";

    if ($("#myfile").val() == "") {
        result = "File upload kosong!";
        return result;
    }

    return "success";
}
