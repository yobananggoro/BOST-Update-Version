$(function () {
    userCodeList();
});

function userCodeList() {
    // alert("aa");
    $.ajax({
        url: "user-code-list",
        type: "GET",
        // data: "",
        success: function (data) {
            $(".loading-page").hide(); //show progress bar
            // console.log(data);
            if (data.status == 200) {
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

                dropdown.trigger('change.select2');
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