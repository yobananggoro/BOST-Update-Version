$(function () {
    $("#getUserCodeList").select2({ placeholder: "- Pilih -", allowClear: true }).one("select2:open", userCodeList);
});

function userCodeList() {
    let dropdown = $("#getUserCodeList");
    dropdown.prop("disabled", true);
    $("#userCodeOverlay").css("display", "flex");

    $.ajax({
        url: "user-code-list",
        type: "GET",
        // data: "",
        success: function (data) {
            $(".loading-page").hide(); //show progress bar
            // console.log(data);
            if (data.status == 200) {
                $(".toastrDefaultInfo").show(function () {
                    toastr.info("Cost Center ready!");
                });

                let dropdown = $("#getUserCodeList");
                dropdown.empty();
                dropdown.append('<option value="">- Pilih -</option>');

                data.listTrx.forEach(function (item) {
                    dropdown.append('<option value="' + item.description + '" data-first="' + item.userCode1 + '" data-second="' + item.userCode2 + '">' + item.description + "</option>");
                });

                // Set dbCode and crCode to input when dropdown changes
                dropdown.on('change', function () {
                    var selected = $(this).find('option:selected');
                    var usrCodeFirst = selected.data('first') || '';
                    var usrCodeSecond = selected.data('second') || '';
                    // alert(usrCodeFirst + ' - ' + usrCodeSecond);
                    $('#userCode1').val(usrCodeFirst);
                    $('#userCode2').val(usrCodeSecond);
                });

                dropdown.trigger("change.select2");
                dropdown.prop("disabled", false).trigger("change");
                $("#userCodeOverlay").hide();
                setTimeout(function () {
                    dropdown.select2("open");
                }, 50);
            } else {
                dropdown.prop("disabled", false);
                $("#userCodeOverlay").hide();
                $(".toastrDefaultError").show(function () {
                    toastr.error(data.message);
                });
            }
        },
        error: function (error) {
            dropdown.prop("disabled", false);
            $("#userCodeOverlay").hide();
            $(".toastrDefaultError").show(function () {
                toastr.error(error);
            });
        },
    });
}