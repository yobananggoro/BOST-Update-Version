$(function() {
    // // Disable right-click
    // document.addEventListener('contextmenu', (e) => e.preventDefault());
    
    // function ctrlShiftKey(e, keyCode) {
    //     return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
    // }
    
    // document.onkeydown = (e) => {
    //     // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
    //     if (
    //         event.keyCode === 123 ||
    //         ctrlShiftKey(e, 'I') ||
    //         ctrlShiftKey(e, 'J') ||
    //         ctrlShiftKey(e, 'C') ||
    //         (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
    //     )
    //     return false;
    // };
    
    $("#btnEnter").click(function(){
        // alert('sbmt');
        var cek = validateForm();
        if(cek!="success"){ 
            alert(cek);
            return false; 
        }
        unformatAllVal();
        // $("#formInput").attr('target', '_self').submit();
    });
    
    $("#btnPrintPDF").click(function(){
        // alert('prnt');
        var cek = validateForm();
        if(cek!="success"){ 
            alert(cek);
            return false; 
        }
        unformatAllVal();
        // $("#formPdf").attr('target', '_self').submit();
    });
    
    $("#dataTables").DataTable();
});

function validateForm(){
    var result = "success";
    
    if($('#startDate').val() == ""){
        $("#startDate").css("background-color","red");
        
        result = "Start Date Tidak Boleh Kosong";
        return result;
    } else {
        $("#startDate").css("background-color","");
    }
    
    if($('#endDate').val() == ""){
        $("#endDate").css("background-color","red");
        
        result = "End Date Tidak Boleh Kosong";
        return result;
    } else {
        $("#endDate").css("background-color","");
    }
    
    if($('#userid').val() == ""){
        $("#userid").css("background-color","red");
    
        result = "User ID Tidak Boleh Kosong";
        return result;
    } else {
        $("#userid").css("background-color","");
    }

    if($('#branch').val() == ""){
        $("#branch").css("background-color","red");
    
        result = "Branch Tidak Boleh Kosong";
        return result;
    } else {
        $("#branch").css("background-color","");
    }
    
    return "success";
}

function getRequest(sel){
    if(sel.id == "startDate"){
        $("#startDate_").val(sel.value);
    } else if(sel.id == "endDate"){
        $("#endDate_").val(sel.value);
    } else if(sel.id == "userid"){
        $("#userID_").val(sel.value);
    } else if(sel.id == "branch"){
        $("#branch_").val(sel.value);
    }
}