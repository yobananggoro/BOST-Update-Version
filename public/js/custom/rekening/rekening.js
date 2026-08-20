$(function () {
    $("#dataTable").DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: true,
    });
});

function cekGI33() {
    var branch  = $('#branch').val();
    var cif     = $('#cif').val();
    var suffix  = $('#suffix').val();

    $('.loading-page').show(); //show progress bar
    
    $.ajax({
        url: "account-gi", 
        type: "POST",
        data: {
            "branch": branch,
            "cif": cif,
            "suffix": suffix,
        }, 
        success:function(data){ 
            $('.loading-page').hide(); //show progress bar
            //fill data to form
            // console.log(data);
            if(data.code == '00'){
                // alert('sukses');
                $("#branch_").val(data.branch);
                $("#cif_").val(data.cif);
                $("#suffix_").val(data.suffix);
                $("#externalNum").val(data.externalAccountNumber);
                $("#nama").val(data.accountShortName);
                $("#tipe_rek").val(data.accountType);
                $("#tipe_ccy").val(data.currency);
                
                $('.toastrDefaultInfo').show(function() {
                    toastr.info("Data ditemukan!")
                });
            } else {
                if(data.msgid == 'MDW0068'){
                    $('.toastrDefaultError').show(function() {
                        toastr.error("Kesalahan, Silahkan coba kembali.")
                    });
                } else {
                    $('.toastrDefaultError').show(function() {
                        toastr.error("Data tidak ditemukan!")
                    });
                }
            }  
        },
        error:function(error){
            // console.log(error);
        
            $('.toastrDefaultError').show(function() {
                toastr.error(error)
            });
        }
    });
}