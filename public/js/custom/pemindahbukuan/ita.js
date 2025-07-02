$(function() {
    $("#btnEnter").click(function(){
        // alert('das');
        var cek = validateForm();
        if(cek!="success"){
            alert(cek);
            return false; 
        }
        $(".loading-page").show();
        $("#formAccount").attr('target', '_self').submit();
    });
    
    $("#listRekening").click(function(){ 
        //resetContent()
    });
    
    $('#nominal_').keyup(function(){
        var nom = $('#nominal_').val();
        
        if(nom.length > 0){
            $('#nominal').val(parseFloat(nom.replace(/,/g, "")));
        } else {
            $('#nominal').val("");
        }
    });
    
    $('.rekSumber').keyup(function(e){
        $(".detailSrc").val("");
        $(".detailSrc").html("");
    });
    
    $('.rekTujuan').keyup(function(e){
        $(".detailDst").val("");
        $(".detailDst").html("");
    });
    
    $('.nar').keyup(function(e){
        this.value = this.value.replace(/[^a-zA-Z0-9 \t\n\r]/g, '');
    });
});

function validateForm(){
    var result      = "success";
    var branchSrc   = $('#branchSrc').val();
    var cifSrc      = $('#cifSrc').val();
    var suffixSrc   = $('#suffixSrc').val();
    var branchDst   = $('#branchDst').val();
    var cifDst      = $('#cifDst').val();
    var suffixDst   = $('#suffixDst').val();
    
    if(branchSrc == "" || cifSrc == "" || suffixSrc == ""){
        $("#branchSrc").css("background-color","red");
        $("#cifSrc").css("background-color","red");
        $("#suffixSrc").css("background-color","red");
        
        result = "Rekening Sumber Tidak Boleh Kosong";
        return result;
    }
    
    if($('#tipeSrc').val() == ""){
        result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Sumber";
        return result;
    }
    
    if(branchDst == "" || cifDst == "" || suffixDst == ""){
        $("#branchDst").css("background-color","red");
        $("#cifDst").css("background-color","red");
        $("#suffixDst").css("background-color","red");
        
        result = "Rekening Tujuan Tidak Boleh Kosong";
        return result;
    }
    
    if($('#tipeDst').val() == ""){
        result = "Klik tombol Detail terlebih dahulu pada kolom Rekening Tujuan";
        return result;
    }
    
    if($('#nominal_').val() == ""){
        $("#nominal_").css("background-color","red");
        
        result = "Nominal Tidak Boleh Kosong";
        return result;
    } else{
        $("#nominal_").css("background-color","");
    }

    if($('#nominal').val() == 0){
        $("#nominal_").css("background-color","red");
        
        result = "Nominal Tidak Boleh diisi Angka 0!";
        return result;
    } else{
        $("#nominal_").css("background-color","");
    }
    
    return "success";
}

function validasiLimit(){ 
    var nominal = parseInt(document.getElementById('nominal').value);
    var limit = parseInt(document.getElementById('limit').value);
    
    if(nominal > limit){
        alert('Limit melebihi ketentuan, silahkan lakukan otorisasi!');
        $("#otorisasi").show();
        $("#subm").show();
        $("#verified").hide();
    } else {
        $("#verified").hide();
        $("#subm").show();
    }
}

function detailSumber(){
    // alert('ds');
    var branch  = $("#branchSrc").val();
    var cif     = $("#cifSrc").val();
    var suffix  = $("#suffixSrc").val();
    
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
            // console.log(data);
            if(data.status == 200){
                if(data.code == '00'){
                    $("#nama_sumber").html(data.accountShortName);
                    $("#tipe_rek_sumber").html(data.accountType);
                    $("#tipe_ccy_sumber").html(data.currency);
                    
                    $("#tipeSrc").val(data.accountType);
                    $("#namaSrc").val(data.accountShortName);
                    $("#ccySrc").val(data.currency);
                    
                    $('.toastrDefaultInfo').show(function() {
                        toastr.info("Data ditemukan!")
                    });
                } else {
                    $('.toastrDefaultError').show(function() {
                        toastr.error(data.msgdesc)
                    });
                }
            } else if(data.status == 500){
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            } else if(data.status == 400){
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            } else{
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            }
        },
        error:function(error){
            $('.loading-page').hide();
            $('.toastrDefaultError').show(function() {
                toastr.error(error)
            });
        }
    });
}

function detailTujuan(){
    var branch  = $("#branchDst").val();
    var cif     = $("#cifDst").val();
    var suffix  = $("#suffixDst").val();
    
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
            // console.log(data);
            
            if(data.status == 200){
                if(data.code == '00'){
                    $("#nama_tujuan").html(data.accountShortName);
                    $("#tipe_rek_tujuan").html(data.accountType);
                    $("#tipe_ccy_tujuan").html(data.currency);
                    
                    $("#tipeDst").val(data.accountType);
                    $("#namaDst").val(data.accountShortName);
                    $("#ccyDst").val(data.currency);
                    
                    $('.toastrDefaultInfo').show(function() {
                        toastr.info("Data ditemukan!")
                    });
                } else {
                    $('.toastrDefaultError').show(function() {
                        toastr.error(data.msgdesc)
                    });
                }
            } else if(data.status == 500){
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            } else if(data.status == 400){
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            } else{
                $('.toastrDefaultError').show(function() {
                    toastr.error(data.message)
                });
            }
        },
        error:function(error){
            $('.loading-page').hide(); //hide progress bar
            $('.toastrDefaultError').show(function() {
                toastr.error(error)
            });
        }
    });
}

// Modal List Rekening Start
function listRekening(action){
    var nama = $('#namaRekening').val();
    var cif = $('#cifRekening').val();
    var i = $('#paging').val() == "" ? 1 : parseInt($('#paging').val());
    var page = i;
    
    if(action == 'next'){
        page = i+1;
    } else if(action == 'prev'){
        page = i-1;
    } else {
        page = i;
    }
    
    $.ajax({
        url: "rekening-list?page="+page, 
        type: "GET",
        data: {'nama':nama, 'cif':cif},
        cache: true,
        success:function(response){ 
            console.log(response.data);
            
            var table_data = '';
            $('#tableData').empty();
            
            for(var i = 0; i<response.data.length;i++) {
                table_data += '<tr onclick="getRowData(this)">';
                table_data += '<td class="text-center">'+ (i+1) +'.</td>';
                table_data += '<td class="nameAccount">' + response.data[i].nama + '</td>'
                table_data += '<td class="noAccount text-center">' + response.data[i].branch +"-"+ response.data[i].cif +"-"+ response.data[i].suffix + '</td>'
                table_data += '<td class="zlab" style="display:none">' + response.data[i].branch + '</td>'
                table_data += '<td class="zlan" style="display:none">' + response.data[i].cif + '</td>'
                table_data += '<td class="zlas" style="display:none">' + response.data[i].suffix + '</td>'
                table_data += '<td class="tipeAccount text-center">' + response.data[i].tipe_rek + '</td>'
                table_data += '<td class="tipeCcy text-center">' + response.data[i].tipe_ccy + '</td>'
                table_data += '</tr>'; 
            }
            
            $('#tableData').append(table_data);
            $('#halaman').html('Halaman ke : '+page);
            $('#paging').val(parseInt(page));
            
            if($('#paging').val() == null || $('#paging').val() < 2){
                // alert('a');
                $('#prev').css('visibility', 'hidden');
            } else {
                // alert('b');
                $('#prev').css('visibility', 'visible');
            }
        }  
    });
}

function getRowData(element){
    var zlab = $(element).find(".zlab").text();
    var zlan = $(element).find(".zlan").text();
    var zlas = $(element).find(".zlas").text();
    
    if($('#branchSrc').val()=="" || $('#cifSrc').val()=="" || $('#suffixSrc').val()==""){
        $('#branchSrc').val(zlab);
        $('#cifSrc').val(zlan);
        $('#suffixSrc').val(zlas);
        $('#closeModal').click();
        $('#branchSrc').focus();exit;
    } else{
        $('#branchDst').val(zlab);
        $('#cifDst').val(zlan);
        $('#suffixDst').val(zlas);
        $('#closeModal').click();
        $('#branchDst').focus();
    }
}

function paginate(id){
    var action = id;
    listRekening(action);
}

function resetContent(){
    $("#tableData").empty();
    $("#paging").empty().val("");
    $("#halaman").empty();
    $("#namaRekening").val("");
    $("#cifRekening").val("");
}
// Modal List Rekening End