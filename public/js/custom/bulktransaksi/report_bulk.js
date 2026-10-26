$(function () {
    // Tambahkan parameter 'e' untuk menangkap event klik
    $("#btnPrintPDF").click(function (e) {
        e.preventDefault(); 
        
        var cek = validateForm();
        if (cek != "success") {
            alert(cek);
            return false;
        } 
        
        if (typeof unformatAllVal === "function") {
            unformatAllVal();
        }

        exportData();
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
    }, 300);
}

function validateForm() {
    // alert($('#status_bulk').val());
    var result = "success";

    if ($('#createdBy').val() == "") {
        $("#createdBy").css("background-color", "red");

        result = "User ID Operator Tidak Boleh Kosong";
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