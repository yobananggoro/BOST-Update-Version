$(function () {
    $("#btnPrintPDF").click(function () {
        // alert('prnt');
        var cek = validateForm();
        if (cek != "success") {
            alert(cek);
            return false;
        } else {
            exportData();
        }
        unformatAllVal();
        // $("#formPdf").attr('target', '_self').submit();

    });
});

function exportData() {
    // alert('export');
    let form = document.getElementById('mainForm');
    
    form.action = exportUrl;
    form.target = "_blank";
    form.submit();

    setTimeout(() => {
        form.action = mainUrl;
        form.target = "_self";
    }, 100);
    // alert(form.action);
}

function validateForm() {
    // alert($('#status_bulk').val());
    var result = "success";

    if ($('#userID').val() == "") {
        $("#userID").css("background-color", "red");

        result = "User ID Tidak Boleh Kosong";
        return result;
    } else {
        $("#userID").css("background-color", "");
    }

    if ($('#branch').val() == "") {
        $("#branch").css("background-color", "red");

        result = "Branch Tidak Boleh Kosong";
        return result;
    } else {
        $("#branch").css("background-color", "");
    }

    if ($('#status_bulk').val() == "") {
        $("#status_bulk").css("background-color", "red");

        result = "Status Transaksi Harus di Pilih";
        return result;
    } else {
        $("#status_bulk").css("background-color", "");
    }

    if ($('#status_bulk').val() != "EXECUTED") {
        $("#status_bulk").css("background-color", "red");

        result = "Hanya boleh status EXECUTED yang bisa di print";
        return result;
    } else {
        $("#status_bulk").css("background-color", "");
    }

    if ($('#startDate').val() == "") {
        $("#startDate").css("background-color", "red");

        result = "Start Date Tidak Boleh Kosong";
        return result;
    } else {
        $("#startDate").css("background-color", "");
    }

    if ($('#endDate').val() == "") {
        $("#endDate").css("background-color", "red");

        result = "End Date Tidak Boleh Kosong";
        return result;
    } else {
        $("#endDate").css("background-color", "");
    }

    return "success";
}

function getRequest(sel) {
    if (sel.id == "startDate") {
        $("#startDate_").val(sel.value);
    } else if (sel.id == "endDate") {
        $("#endDate_").val(sel.value);
    } else if (sel.id == "userid") {
        $("#userID_").val(sel.value);
    } else if (sel.id == "branch") {
        $("#branch_").val(sel.value);
    }
}